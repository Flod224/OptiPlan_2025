<?php

namespace App\Http\Controllers;
use App\Models\Soutenance;
use App\Models\Sessions;
use App\Models\Professeurs;
use App\Models\Etudiants;
use App\Models\User;
use App\Notifications\EnvoiProgrammeEnseignants;
use App\Notifications\EnvoiProgrammeStudents;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;

class ProgrammesController extends Controller
{
    public function pgpreSout($idSess, $type)
    {
        $sessionActive = Sessions::where('id',$idSess)->first();

        if($type === 'sout'){

            $nombreTotalEtudiants = User::where('role', 0)->count();

            $nombreTotalEtudiantsEnPre = Etudiants::join('soutenance', 'etudiants.id', '=', 'soutenance.etudiant_id')
                ->where('etudiants.is_ready', 1)
                ->where('soutenance.session_id', $idSess)
                ->count();

            $nombreTotalEtudiantsEnSout = Etudiants::join('soutenance', 'etudiants.id', '=', 'soutenance.etudiant_id')
                ->where('etudiants.is_ready', 3)
                ->where('soutenance.session_id', $idSess)
                ->count();

            $nombreTotalProfesseurs = Professeurs::count();

            $sessions = Sessions::all('*');

            $soutenances = Soutenance::where('type', $type)
            ->where('session_id', $idSess)
            ->orderBy('jury_id', 'asc')
            ->orderBy('jour', 'asc')
            ->orderBy('horaire_id', 'asc')
            ->with('etudiant.users', 'session', 'salle', 'horaire', 'jury')
            ->get();
            
            $value = '';
            $nameSession = Sessions::find($idSess);
            $sessionStart = Carbon::parse($nameSession->session_start);
            $month = $sessionStart->month;
            switch ($month) {
                case 1:
                    $month = 'JANVIER';
                    break;
                case 2:
                    $month = 'FÉVRIER';
                    break;
                case 3:
                    $month = 'MARS';
                    break;
                case 4:
                    $month = 'AVRIL';
                    break;
                case 5:
                    $month = 'MAI';
                    break;
                case 6:
                    $month = 'JUIN';
                    break;
                case 7:
                    $month = 'JUILLET';
                    break;
                case 8:
                    $month = 'AOÛT';
                    break;
                case 9:
                    $month = 'SEPTEMBRE';
                    break;
                case 10:
                    $month = 'OCTOBRE';
                    break;
                case 11:
                    $month = 'NOVEMBRE';
                    break;
                case 12:
                    $month = 'DÉCEMBRE';
                    break;
            }

            $year = $sessionStart->year;
            if($type === 'pre'){
                $value = 'PRESOUTENANCE'; 
            }else{
                $value = 'SOUTENANCE';
            }
            return view('AdminPages.AdminDashboard', compact('idSess','sessionActive','type','nombreTotalEtudiants','nombreTotalEtudiantsEnSout','nombreTotalEtudiantsEnPre','nombreTotalProfesseurs','sessions','soutenances','value','month','year'));
        }
        else if($type === 'pre')
        {
            $professeurs = Professeurs::all('*');
            $etudiants = Etudiants::all('*');
            $nombreTotalEtudiants = User::where('role', 0)->count();
            $nombreTotalEtudiantsEnPre = Etudiants::where('is_ready', 1)->count();
            $nombreTotalEtudiantsEnSout = Etudiants::where('is_ready', 3)->count();
            $nombreTotalProfesseurs = Professeurs::count();
            $sessions = Sessions::all('*');

            $soutenances = Soutenance::where('state', $type)
            ->where('session_id', $idSess)
            ->orderBy('jour', 'asc') // Ordonne par date croissante
            ->with('etudiant.users', 'session', 'salle', 'horaire', 'jury')
            ->get();

            $soutenancesGroupedByExaminateurPresident = $soutenances->groupBy(function ($soutenance) {
                $examinateurId = $soutenance->jury->examinateur;
                $presidentId = $soutenance->jury->president;
                $horaireId = $soutenance->horaire_id;
                $salleId = $soutenance->salle_id;
            
                return "{$examinateurId}-{$presidentId}-{$horaireId}-{$salleId}";
            });
            
            $filieresParExaminateurPresident = [];
            
            foreach ($soutenancesGroupedByExaminateurPresident as $examinateurPresidentHoraireSalle => $soutenancesExaminateurPresident) {
                list($examinateurId, $presidentId, $horaireId, $salleId) = explode('-', $examinateurPresidentHoraireSalle);
            
                $examinateurNomPrenom = Professeurs::where('id', $examinateurId)->with('gradeProfesseur')->first();
                $presidentNomPrenom = Professeurs::where('id', $presidentId)->with('gradeProfesseur')->first();

                $juryInfo = [
                    'examinateur' => [
                        'nom' => $examinateurNomPrenom->nom,
                        'prenom' => $examinateurNomPrenom->prenom,
                        'grade' => $examinateurNomPrenom->gradeProfesseur->nom
                    ],
                    'president' => [
                        'nom' => $presidentNomPrenom->nom,
                        'prenom' => $presidentNomPrenom->prenom,
                        'grade' => $presidentNomPrenom->gradeProfesseur->nom
                    ],
                ];            

                $filteredSoutenances = $soutenancesExaminateurPresident->filter(function ($soutenance) use ($soutenancesExaminateurPresident) {
                    return $soutenance->horaire_id === $soutenancesExaminateurPresident[0]->horaire_id
                        && $soutenance->salle_id === $soutenancesExaminateurPresident[0]->salle_id
                        && $soutenance->jour === $soutenancesExaminateurPresident[0]->jour;
                });
                $filieresParExaminateurPresident[$examinateurPresidentHoraireSalle] = [
                    'juryInfo' => $juryInfo,
                    'filieres' => $filteredSoutenances->pluck('etudiant.filiere')->unique()->values(),
                    'niveau_etude' => $filteredSoutenances->pluck('etudiant.niveau_etude')->unique()->values(),
                ];
            }
        
            $value = '';
            $nameSession = Sessions::find($idSess);
            Carbon::setLocale('fr');
            $sessionStart = Carbon::parse($nameSession->session_start);
            $month = $sessionStart->month;
            switch ($month) {
                case 1:
                    $month = 'JANVIER';
                    break;
                case 2:
                    $month = 'FÉVRIER';
                    break;
                case 3:
                    $month = 'MARS';
                    break;
                case 4:
                    $month = 'AVRIL';
                    break;
                case 5:
                    $month = 'MAI';
                    break;
                case 6:
                    $month = 'JUIN';
                    break;
                case 7:
                    $month = 'JUILLET';
                    break;
                case 8:
                    $month = 'AOÛT';
                    break;
                case 9:
                    $month = 'SEPTEMBRE';
                    break;
                case 10:
                    $month = 'OCTOBRE';
                    break;
                case 11:
                    $month = 'NOVEMBRE';
                    break;
                case 12:
                    $month = 'DÉCEMBRE';
                    break;
            }
        
            $year = $sessionStart->year;
        
            if ($type === 'pre') {
                $value = 'PRESOUTENANCE';
            } else {
                $value = 'SOUTENANCE';
            }
            return view('AdminPages.AdminDashboard', compact('idSess','sessionActive','type','soutenancesGroupedByExaminateurPresident', 'filieresParExaminateurPresident','professeurs','nombreTotalEtudiants','nombreTotalEtudiantsEnSout','nombreTotalEtudiantsEnPre','nombreTotalProfesseurs','sessions', 'value','month','year'));

        }
    }
    public function programmeSendEtudiants(Request $request)
    {
        $request->validate([
            'lien_whatsapp' => 'required|url',
        ], [
            'lien_whatsapp' => 'Entrez un lien valide',
        ]);

        $lienWhatsapp = $request->input('lien_whatsapp');
        $type = $request->input('type');

        $idSess = $request->input('idSess');
        $month = $request->input('month');
        $year = $request->input('year');

        $etudiants = Soutenance::where('type', $type)
            ->where('session_id', $idSess)
            ->with('etudiant.users', 'session', 'salle', 'horaire', 'jury')
            ->get();

        if ($etudiants->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun étudiant programmé');
        }

        $soutenancesGroupedByExaminateurPresident = $etudiants->groupBy(function ($soutenance) {
            $examinateurId = $soutenance->jury->examinateur;
            $presidentId = $soutenance->jury->president;
            $horaireId = $soutenance->horaire_id;
            $salleId = $soutenance->salle_id;
        
            return "{$examinateurId}-{$presidentId}-{$horaireId}-{$salleId}";
        });
            
        $filieresParExaminateurPresident = [];
            
        foreach ($soutenancesGroupedByExaminateurPresident as $examinateurPresidentHoraireSalle => $soutenancesExaminateurPresident) {
            // Filtrer les soutenances du jury à la même heure dans la même salle
            $filteredSoutenances = $soutenancesExaminateurPresident->filter(function ($soutenance) use ($soutenancesExaminateurPresident) {
                return $soutenance->horaire_id === $soutenancesExaminateurPresident[0]->horaire_id
                    && $soutenance->salle_id === $soutenancesExaminateurPresident[0]->salle_id
                    && $soutenance->jour === $soutenancesExaminateurPresident[0]->jour;
            });
        
            $filieresParExaminateurPresident[$examinateurPresidentHoraireSalle] = $filteredSoutenances->pluck('etudiant.filiere')->unique()->values();
        }

        $value = '';

        if($type === 'pre'){
            $value = 'Pré-soutenances'; 
        }else{
            $value = 'Soutenances';
        }

        foreach ($etudiants as $etudiant) {

            $etudiant->etudiant->user->notify(new EnvoiProgrammeStudents($lienWhatsapp, $type, $month, $etudiants,$soutenancesGroupedByExaminateurPresident,
            $filieresParExaminateurPresident ,$value,$year, $idSess));
        }

        return redirect()->back()->with('success', 'Programme envoyé avec succès');
    }
    public function programmeSendEnseignants($idSess, $type, $year, $month)
    {
        $soutenances = Soutenance::where('type', $type)
            ->where('session_id', $idSess)
            ->orderBy('jour', 'asc') // Ordonne par date croissante
            ->with('etudiant.users', 'session', 'salle', 'horaire', 'jury','jury.examinateurs', 'jury.presidents', 'jury.rapporteurs')
            ->get();
            
        $soutenancesGroupedByExaminateurPresident = $soutenances->groupBy(function ($soutenance) {
            $examinateurId = $soutenance->jury->examinateur;
            $presidentId = $soutenance->jury->president;
            $horaireId = $soutenance->horaire_id;
            $salleId = $soutenance->salle_id;
        
            return "{$examinateurId}-{$presidentId}-{$horaireId}-{$salleId}";
        });
        
        $filieresParExaminateurPresident = [];

        foreach ($soutenancesGroupedByExaminateurPresident as $examinateurPresidentHoraireSalle => $soutenancesExaminateurPresident) {
            list($examinateurId, $presidentId, $horaireId, $salleId) = explode('-', $examinateurPresidentHoraireSalle);
        
            $examinateurNomPrenom = Professeurs::where('id', $examinateurId)->with('gradeProfesseur')->first();
            $presidentNomPrenom = Professeurs::where('id', $presidentId)->with('gradeProfesseur')->first();

            $juryInfo = [
                'examinateur' => [
                    'nom' => $examinateurNomPrenom->nom,
                    'prenom' => $examinateurNomPrenom->prenom,
                    'grade' => $examinateurNomPrenom->gradeProfesseur->nom
                ],
                'president' => [
                    'nom' => $presidentNomPrenom->nom,
                    'prenom' => $presidentNomPrenom->prenom,
                    'grade' => $presidentNomPrenom->gradeProfesseur->nom
                ],
            ];            

            $filteredSoutenances = $soutenancesExaminateurPresident->filter(function ($soutenance) use ($soutenancesExaminateurPresident) {
                return $soutenance->horaire_id === $soutenancesExaminateurPresident[0]->horaire_id
                    && $soutenance->salle_id === $soutenancesExaminateurPresident[0]->salle_id
                    && $soutenance->jour === $soutenancesExaminateurPresident[0]->jour;
            });
            $filieresParExaminateurPresident[$examinateurPresidentHoraireSalle] = [
                'juryInfo' => $juryInfo,
                'filieres' => $filteredSoutenances->pluck('etudiant.filiere')->unique()->values(),
                'niveau_etude' => $filteredSoutenances->pluck('etudiant.niveau_etude')->unique()->values(),
            ];
        }

        $etudiants = $soutenances;

        $value = '';

        if($type === 'pre'){
            $value = 'Pré-soutenances'; 
        }else{
            $value = 'Soutenances';
        }

        if ($etudiants->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun étudiant programmé');
        }

        $notifiedProfessors = [];

        foreach ($soutenances as $soutenance) {
            $examinateurs = $soutenance->jury->examinateurs;
            $presidents = $soutenance->jury->presidents;
            $rapporteurs = $soutenance->jury->rapporteurs;

            $professors = [
                'examinateur' => $examinateurs,
                'president' => $presidents,
                'rapporteur' => $rapporteurs,
            ];

            foreach ($professors as $role => $professor) {
                $nomProf = $professor->nom;
                $prenomProf = $professor->prenom;
                $sexeProf = $professor->sexe === 'F' ? 'Madame' : 'Monsieur';
                $email = $professor->email;

                if (!isset($notifiedProfessors[$email])) {
                    $professor->notify(new EnvoiProgrammeEnseignants(
                        $type, $month, $soutenances, $soutenancesGroupedByExaminateurPresident,
                        $filieresParExaminateurPresident, $value, $year, $idSess,
                        $nomProf, $prenomProf, $sexeProf
                    ));

                    $notifiedProfessors[$email] = true;
                }
            }
        }

        // foreach ($soutenances as $soutenance) {
        //     $examinateurs = $soutenance->jury->examinateurs;
        //     $presidents = $soutenance->jury->presidents;
        //     $rapporteurs = $soutenance->jury->rapporteurs;

        //     $nomProfEx = $examinateurs->nom;
        //     $prenomProfEx = $examinateurs->prenom;
            
        //     if($examinateurs->sexe === 'F'){
        //         $sexeEx =  'Madame';
        //     } else {
        //         $sexeEx =  'Monsieur';
        //     }
            

        //     $nomProfPr = $presidents->nom;
        //     $prenomProfPr = $presidents->prenom;
        //     $sexePr = $presidents->sexe;

        //     if($presidents->sexe === 'F'){
        //         $sexePr =  'Madame';
        //     } else {
        //         $sexePr =  'Monsieur';
        //     }

        //     $nomProfRp = $rapporteurs->nom;
        //     $prenomProfRp = $rapporteurs->prenom;
        //     $sexeRp = $rapporteurs->sexe;

        //     if($rapporteurs->sexe === 'F'){
        //         $sexeRp =  'Madame';
        //     } else {
        //         $sexeRp =  'Monsieur';
        //     }
            
        //     $examinateurs->notify(new EnvoiProgrammeEnseignants($type, $month, $soutenances, $soutenancesGroupedByExaminateurPresident,$filieresParExaminateurPresident ,$value,$year, $idSess, $nomProfEx, $prenomProfEx, $sexeEx ));

        //     $presidents->notify(new EnvoiProgrammeEnseignants($type, $month, $soutenances, $soutenancesGroupedByExaminateurPresident,$filieresParExaminateurPresident ,$value,$year, $idSess, $nomProfPr, $prenomProfPr, $sexePr));
            
        //     $rapporteurs->notify(new EnvoiProgrammeEnseignants($type, $month, $soutenances, $soutenancesGroupedByExaminateurPresident,$filieresParExaminateurPresident ,$value,$year, $idSess, $nomProfRp, $prenomProfRp, $sexeRp));

        // }

        return redirect()->back()->with('success', 'Programme envoyé avec succès');
    }
    public function generateInvitations($sessionId)
    {
        Carbon::setLocale('fr');

        $session = Sessions::findOrFail($sessionId);
        $sessionStart = $session->session_start;
        $month = Carbon::parse($sessionStart)->translatedFormat('F');
        $year = Carbon::parse($sessionStart)->year;

        $enseignants = Professeurs::all();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        foreach ($enseignants as $enseignant) {
            $dompdf = new Dompdf($options);

            $nomProf = $enseignant->nom;
            $prenomProf = $enseignant->prenom;
            $sexe = $enseignant->sexe === 'F' ? 'Madame' : 'Monsieur';

            $html = view('Pdf.Invitation', compact('nomProf', 'prenomProf', 'sexe', 'month', 'year'))->render();

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $output = $dompdf->output();
            $filename = 'invitations/' . $nomProf . '_' . $prenomProf . '.pdf';

            Storage::disk('local')->put($filename, $output);
        }

        return redirect()->back()->with('success', 'Invitations générées avec succès.');
    }

    public function generatePvs($sessionId)
    {
        $soutenances = Soutenance::where('type', 'sout')
                                  ->where('session_id', $sessionId)
                                  ->with(['etudiant.users', 'jury.presidents.gradeProfesseur','jury.examinateurs.gradeProfesseur','jury.rapporteurs.gradeProfesseur'])
                                  ->get();

        foreach ($soutenances as $soutenance) {
            $etudiant = $soutenance->etudiant;
            $user = $etudiant->user;
            $juryId = $soutenance->jury;
            $niveau = $etudiant->niveau_etude === 'Licence' ? 'LP' : 'MP';
            
            $president = $juryId->presidents;
            $examinateur = $juryId->examinateurs;
            $rapporteur = $juryId->rapporteurs;

            $gradeEx = $juryId->examinateurs->gradeProfesseur->nom === 'Ingénieur' ? 'Ing.' : ($juryId->examinateurs->gradeProfesseur->nom === 'Docteur' ? 'Dr' : ($juryId->examinateurs->gradeProfesseur->nom === 'Professeur' ? 'Prof.' : $juryId->examinateurs->gradeProfesseur->nom));
            $gradePr = $juryId->presidents->gradeProfesseur->nom === 'Ingénieur' ? 'Ing.' : ($juryId->presidents->gradeProfesseur->nom === 'Docteur' ? 'Dr' : ($juryId->presidents->gradeProfesseur->nom === 'Professeur' ? 'Prof.' : $juryId->presidents->gradeProfesseur->nom));
            $gradeRp = $juryId->rapporteurs->gradeProfesseur->nom === 'Ingénieur' ? 'Ing.' : ($juryId->rapporteurs->gradeProfesseur->nom === 'Docteur' ? 'Dr' : ($juryId->rapporteurs->gradeProfesseur->nom === 'Professeur' ? 'Prof.' : $juryId->rapporteurs->gradeProfesseur->nom));

            $date = Carbon::parse($soutenance->jour)->locale('fr')->isoFormat('D MMMM YYYY');
            
            $data = [
                'date' => $date,
                'nomPrenom' => $user->nom . ' ' . $user->prenom,
                'dateLieuNaissance' => $etudiant->birthday,
                'numMatricule' => $user->matricule,
                'specialite' => $niveau . '-'. $etudiant->filiere,
                'promotion' => $etudiant->annee_soutenance,
                'tel' => $etudiant->phone,
                'theme' => $etudiant->theme,
                'examinateur' => $gradeEx . ' '. $examinateur->prenom . ' ' . $examinateur->nom,
                'president' => $gradePr . ' '. $president->prenom . ' ' . $president->nom,
                'rapporteur' => $gradeRp . ' '. $rapporteur->prenom . ' ' . $rapporteur->nom,
            ];
            
            $this->generatePvsPdf($data, $user->nom, $user->prenom);
        }

        return redirect()->back()->with('success', 'PVs générés et sauvegardés avec succès.');
    }

    private function generatePvsPdf($data, $nom, $prenom)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', realpath(''));

        $dompdf = new Dompdf($options);

        $html = view('Pdf.PV', $data)->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        // $dompdf->stream('invit.pdf', array('Attachment' => 0));

        $output = $dompdf->output();
        $filename = 'PVs/' .'PV_' . $nom . '_' . $prenom . '.pdf';
        Storage::disk('local')->put($filename, $output);
    }
}
