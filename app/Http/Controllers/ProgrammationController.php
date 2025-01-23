<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\AvailabilityRooms;
use App\Models\AvailabilityTeachers;
use App\Models\Etudiants;
use App\Models\Grades;
use App\Models\Horaires;
use App\Models\Jury;
use App\Models\Professeurs;
use App\Models\Salles;
use App\Models\Sessions;
use App\Models\Soutenance;
use Illuminate\Http\Request;

class ProgrammationController extends Controller
{
    private function getHorairesCommuns($examinateur, $rapporteur, $president, $jour)
    {
        $dispoExaminateur = AvailabilityTeachers::where('prof_id', $examinateur)
            ->where('type', 'sout')
            ->where('jour', $jour)
            ->pluck('deb_fin')
            ->toArray();

        $dispoRapporteur = AvailabilityTeachers::where('prof_id', $rapporteur)
            ->where('type', 'sout')
            ->where('jour', $jour)
            ->pluck('deb_fin')
            ->toArray();

        $dispoPresident = AvailabilityTeachers::where('prof_id', $president)
            ->where('type', 'sout')
            ->where('jour', $jour)
            ->pluck('deb_fin')
            ->toArray();

        $horairesIdsExaminateur = Horaires::whereIn('nom', $dispoExaminateur)->pluck('id')->toArray();
        $horairesIdsRapporteur = Horaires::whereIn('nom', $dispoRapporteur)->pluck('id')->toArray();
        $horairesIdsPresident = Horaires::whereIn('nom', $dispoPresident)->pluck('id')->toArray();

        $communs = array_intersect($horairesIdsExaminateur, $horairesIdsRapporteur, $horairesIdsPresident);
        return $communs;
    }
    private function getDatesDisponibles($examinateur, $rapporteur, $president)
    {
        return AvailabilityTeachers::where('type', 'sout')
            ->pluck('jour')
            ->unique()
            ->toArray();
    }
    public function getHorairesDisponibles(Request $request, $date)
    {
        $examinateur = $request->input('examinateur');
        $rapporteur = $request->input('rapporteur');
        $president = $request->input('president');
        
        $horairesDisponibles = $this->getHorairesCommuns($examinateur, $rapporteur, $president, $date);
        return response()->json($horairesDisponibles);
    }

    public function StudentsInfos($id)
    {
        $etudiant = Etudiants::findOrFail($id);
        $sessions = Sessions::all('*');
        $soutenance = Soutenance::where('etudiant_id', $id)->first();
        $jury = Jury::with('examinateurs', 'rapporteurs', 'presidents')->findOrFail($soutenance->jury_id);
    
        $datesDisponibles = $this->getDatesDisponibles($jury->examinateur, $jury->rapporteur, $jury->president);
    
        $horaire = null;
        $room = null;
        $jour = null;
    
        if ($soutenance->state === 'soutenance') {
            $horaire = $soutenance->horaire_id;
            $room = $soutenance->salle_id;
            $jour = $soutenance->jour;
        }
    
        return view('AdminPages.ProgrammationSoutenance', compact('etudiant', 'sessions', 'soutenance', 'jury', 'datesDisponibles','horaire', 'room', 'jour'));
    }
    public function ShowStudentsEnSout($session_id)
    {
        $etudiants = Etudiants::join('soutenance', 'soutenance.etudiant_id', '=', 'etudiants.id')
        ->join('user', 'user.id', '=', 'etudiants.user_id')
        ->leftJoin('professeurs', 'professeurs.id', '=', 'etudiants.maitre_memoire')
        ->select('user.*', 'etudiants.*')
        ->whereNotNull('etudiants.file')
        ->whereNotNull('etudiants.theme')
        ->where('is_ready', '>=',2)
        ->where('soutenance.session_id', $session_id)
        ->orWhereNull('soutenance.etudiant_id')
        ->orderBy('soutenance.created_at', 'asc')
        ->with('user','professeur')
        ->get();
    
        $sessionSelectionnee = Sessions::select('id','nom', 'session_start_PreSout', 'session_end_PreSout','session_start_Sout', 'session_end_Sout')
        ->where('id', $session_id)
        ->first();

        if ($sessionSelectionnee) {
            $idSess = $sessionSelectionnee->id;
            $description = $sessionSelectionnee->nom;
            $debut_presout = $sessionSelectionnee->session_start_PreSout;
            $fin_presout = $sessionSelectionnee->session_end_PreSout;
            $debut_sout = $sessionSelectionnee->session_start_Sout;
            $fin_sout = $sessionSelectionnee->session_end_Sout;
        } else {
            return redirect()->back()->with('error', 'Session non trouvé');
        }
       
        $sessions = Sessions::where('id',$session_id)->get();
        $sout = Soutenance::where('state', 'soutenance')->where('session_id',$session_id)->count();

        return view('AdminPages.EnSoutenance', compact('description','sout','debut_presout','fin_presout','debut_sout','fin_sout','sessions', 'etudiants'));

    }

    // ----------------------------------------------------------------

    // PRE-SOUTENANCE (Nouvelle version)
    public function preSout($session_id)
    {
        $etudiants = Etudiants::leftJoin('soutenance', 'soutenance.etudiant_id', '=', 'etudiants.id')
        ->join('users', 'users.id', '=', 'etudiants.user_id')
        ->select('users.*', 'etudiants.*')
        ->whereNotNull('etudiants.file')
        ->whereNotNull('etudiants.theme')
        ->orWhereNull('soutenance.etudiant_id')
        ->where('soutenance.session_id', $session_id)
        ->with('user','professeur')
        ->distinct()
        ->get();
    
        $presout = Soutenance::where('type', 'Pre-Soutenance')->where('session_id',$session_id)->count();

        $sessionSelectionnee = Sessions::select('id','nom', 'session_start_PreSout', 'session_end_PreSout')
        ->where('id', $session_id)
        ->first();

        if ($sessionSelectionnee) {
            $idSess = $sessionSelectionnee->id;
            $nom = $sessionSelectionnee->nom;
            $debut_presout = $sessionSelectionnee->session_start_PreSout;
            $fin_presout = $sessionSelectionnee->session_end_PreSout;
            $debut_sout = $sessionSelectionnee->session_start_Sout;
            $fin_sout = $sessionSelectionnee->session_end_Sout;
        } else {
            return redirect()->back()->with('error', 'Session non trouvé');
        }

        $sessions = Sessions::where('id',$session_id)->get();

        return view('AdminPages.PreSoutenanceList', compact('etudiants','nom','presout','idSess','sessions','debut_presout','fin_presout'));

    }

    // ----------------------------------------------------------------

    // SOUTENANCE (Nouvelle version OptiPlan)
    public function Sout($session_id)
    {
        $etudiants = Etudiants::leftJoin('soutenance', 'soutenance.etudiant_id', '=', 'etudiants.id')
        ->join('users', 'users.id', '=', 'etudiants.user_id')
        ->select('users.*', 'etudiants.*')
        ->whereNotNull('etudiants.file')
        ->whereNotNull('etudiants.theme')
        ->orWhereNull('soutenance.etudiant_id')
        ->where('soutenance.session_id', $session_id)
        ->with('user', 'professeur')
        ->distinct()
        ->get();

        
    
        $sout = Soutenance::where('type', 'Soutenance')->where('session_id',$session_id)->count();

        $sessionSelectionnee = Sessions::select('id','nom', 'session_start_PreSout', 'session_end_PreSout')
        ->where('id', $session_id)
        ->first();

        if ($sessionSelectionnee) {
            $idSess = $sessionSelectionnee->id;
            $nom = $sessionSelectionnee->nom;
            $debut_presout = $sessionSelectionnee->session_start_PreSout;
            $fin_presout = $sessionSelectionnee->session_end_PreSout;
            $debut_sout = $sessionSelectionnee->session_start_Sout;
            $fin_sout = $sessionSelectionnee->session_end_Sout;
        } else {
            return redirect()->back()->with('error', 'Session non trouvé');
        }

        $sessions = Sessions::where('id',$session_id)->get();

        return view('AdminPages.SoutenanceList', compact('etudiants','nom','sout','idSess','sessions','debut_presout','fin_presout'));

    }



    public function preSoutProg($session_id)
    {
        $etudiants = Etudiants::whereNotNull('file')
        ->whereNotNull('theme')
        ->where('is_ready', 0)
        ->orderBy('filiere')
        ->with('user')
        ->get();
        
        $professeurs = Professeurs::all('*');
        $horaires = Horaires::all('*');
        $salles = Salles::all('*');
        $sessions = Sessions::where('id',$session_id)->get();
       
        return view('AdminPages.EnPreSoutenance', compact('etudiants','professeurs','horaires','salles','sessions'));

    }
    public function ProfesseursDisponibles(Request $request)
    {
        $horaireId = $request->has('horaire') ? $request->input('horaire') : null;
        $jourSoutenance = $request->has('jourSoutenance') ? $request->input('jourSoutenance') : null;
        $typeSout = $request->has('type') ? $request->input('type') : null;
        $session_id = $request->has('session_id') ? $request->input('session_id') : null;

        $horaire = Horaires::find($horaireId);

        if (!$horaire) {
            return response()->json([
                'error' => 'Horaire non trouvé',
            ]);
        }
        if($typeSout === 'pre'){
            if ($horaireId == 1) {
                $dispo = AvailabilityTeachers::whereHas('dispoProfesseur', function ($query) use ($jourSoutenance, $typeSout, $session_id) {
                    $query->whereIn('deb_fin', ['H1', 'H2', 'H3', 'H4', 'H5'])
                        ->where('jour', $jourSoutenance)
                        ->where('type', $typeSout)
                        ->where('session_id', $session_id)
                        ->where('occupe', 0);
                })->get();
                $examinateursDisponibles = $dispo ;
                $presidentsDisponibles = $dispo ;
            }            
            if($horaireId == 2){
                $dispo = AvailabilityTeachers::whereHas('dispoProfesseur', function ($query) use ($jourSoutenance, $typeSout, $session_id) {
                    $query->whereIn('deb_fin', ['H6', 'H7', 'H8', 'H9', 'H10'])
                        ->where('jour', $jourSoutenance)
                        ->where('type', $typeSout)
                        ->where('session_id', $session_id)
                        ->where('occupe', 0);
                })->get();    
                $examinateursDisponibles = $dispo ;
                $presidentsDisponibles = $dispo ;        
            }
        } else if($typeSout === 'sout'){
            $dispo = AvailabilityTeachers::whereHas('dispoProfesseur', function ($query) use ($horaire, $jourSoutenance, $session_id) {
                $query->where('deb_fin', $horaire->nom)
                    ->where('jour', $jourSoutenance)
                    ->where('type', 'sout')
                    ->where('session_id', $session_id)
                    ->where('occupe',0)
                    ->where(function ($subquery) use ($jourSoutenance, $horaire) {
                        $subquery->whereNotIn('id', function ($countSubquery) use ($jourSoutenance, $horaire) {
                            $countSubquery->select('prof_id')
                                ->from('soutenance')
                                ->where('jour', $jourSoutenance)
                                ->where('horaire_id', $horaire)
                                ->where('type', 'pre')
                                ->groupBy('prof_id')
                                ->havingRaw('COUNT(prof_id) >= 6');
                        });
                    });
            })->get();
            $examinateursDisponibles = $dispo ;
            $presidentsDisponibles = $dispo ;
        }

        return response()->json([
           'examinateurs' => $examinateursDisponibles,
           'presidents' => $presidentsDisponibles,
        ]);
    }
    public function ProfesseursNames(Request $request)
    {
        $examinateursIds = $request->input('examinateursIds');
        $presidentsIds = $request->input('presidentsIds');

        $examinateurs = [];
        if (!empty($examinateursIds)) {
            $examinateurs = Professeurs::with('gradeProfesseur')->whereIn('id', $examinateursIds)->get(['id', 'nom', 'prenom', 'grade']);
        }
        $presidents = [];
        if (!empty($presidentsIds)) {
            $presidents = Professeurs::with('gradeProfesseur')->whereIn('id', $presidentsIds)->get(['id', 'nom', 'prenom','grade']);
        }

        if (empty($examinateurs) && empty($presidents)) {
            return response()->json(['message' => 'Aucun nom n\'a été trouvé.']);
        }

        return response()->json([
            'examinateurs' => $examinateurs,
            'presidents' => $presidents,
        ]);
    }
    public function SallesDisponibles(Request $request)
    {
        $jourSoutenance = $request->input('jourSoutenance');
        $horaireId = $request->input('horaire');
        $typeSout = $request->input('type');
        $session_id = $request->input('session_id');

        $horaire = Horaires::find($horaireId);

        if (!$horaire) {
            return response()->json([
                'error' => 'Horaire non trouvé',
            ]);
        }
        if($typeSout === 'pre'){
            if ($horaireId == 1) {
                $sallesDisponibles = AvailabilityRooms::whereHas('dispoSalles', function ($query) use ($jourSoutenance, $typeSout, $session_id) {
                    $query->whereIn('deb_fin', ['H1', 'H2', 'H3', 'H4', 'H5'])
                        ->where('jour', $jourSoutenance)
                        ->where('type', $typeSout)
                        ->where('session_id', $session_id)
                        ->where('occupe', 0)
                        ->where(function ($subquery) use ($jourSoutenance) {
                            $subquery->whereNotIn('id', function ($countSubquery) use ($jourSoutenance) {
                                $countSubquery->select('salle_id')
                                    ->from('soutenance')
                                    ->where('jour', $jourSoutenance)
                                    ->where('horaire_id', 1)
                                    ->where('type', 'pre')
                                    ->groupBy('salle_id')
                                    ->havingRaw('COUNT(salle_id) >= 6');
                            });
                        });
                })->get();
            }            
            if($horaireId == 2){
                $sallesDisponibles = AvailabilityRooms::whereHas('dispoSalles', function ($query) use ($jourSoutenance, $typeSout, $session_id) {
                    $query->whereIn('deb_fin', ['H6', 'H7', 'H8', 'H9', 'H10'])
                        ->where('jour', $jourSoutenance)
                        ->where('type', $typeSout)
                        ->where('session_id', $session_id)
                        ->where('occupe', 0)
                        ->where(function ($subquery) use ($jourSoutenance) {
                            $subquery->whereNotIn('id', function ($countSubquery) use ($jourSoutenance) {
                                $countSubquery->select('salle_id')
                                    ->from('soutenance')
                                    ->where('jour', $jourSoutenance)
                                    ->where('horaire_id', 2)
                                    ->where('type', 'pre')
                                    ->groupBy('salle_id')
                                    ->havingRaw('COUNT(salle_id) >= 6');
                            });
                        });
                })->get();            
            }
        } else if($typeSout === 'sout'){
            $sallesDisponibles = AvailabilityRooms::whereHas('dispoSalles', function ($query) use ($horaire, $jourSoutenance, $session_id) {
                $query->where('deb_fin', $horaire->nom)
                    ->where('jour', $jourSoutenance)
                    ->where('type', 'sout')
                    ->where('session_id', $session_id)
                    ->where('occupe',0);
            })->get();
        }

        if ($sallesDisponibles->isEmpty()) {
            return response()->json([
                'error' => 'Aucune salle disponible à cette heure et ce jour.',
            ]);
        }

        return response()->json([
            'salles' => $sallesDisponibles,
        ]);
    }
    public function SallesNames(Request $request)
    {
        $salleIdsNested = $request->input('salleIds');
        $salleIds = [];
        foreach ($salleIdsNested as $salle) {
            $salleIds[] = $salle['salle_id'];
        }

        $salles = Salles::whereIn('id', $salleIds)->get(['id', 'nom']);
        
        if ($salles->isEmpty()) {
            return response()->json([
                'error' => 'Aucun nom n\'a été trouvé.',
            ]);
        }

        return response()->json([
            'salles' => $salles,
        ]);
    }
    public function enregistrerPreSoutenance(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|array',
            'jour' => 'required',
            'horaire_id' => 'required',
            'salle_id' => 'required',
            'session_id' => 'required',
            'president' => 'required',
            'examinateur' => 'required',
        ], [
            'etudiant_id.required' => 'Sélectionnez le(s) étudiants.',
            'jour' => 'Choisissez le jour de la soutenance',
            'horaire_id' => 'L\'horaire est important',
            'salle_id' => 'La salle est importante',
            'session_id' => 'La session est importante',
            'president.required' => 'Choisissez un président',
            'examinateur.required' => 'Choisissez un examinateur',
        ]);

        $jourSoutenance = $request->input('jour');
        $horaireId = $request->input('horaire_id');
        $salleId = $request->input('salle_id');
        $sessionId = $request->input('session_id');
        $presidentId = $request->input('president');
        $examinateurId = $request->input('examinateur');
        
        $presidentGrade = Professeurs::where('id', $presidentId)->value('grade');
        $examinateurGrade = Professeurs::where('id', $examinateurId)->value('grade');

        $presidentGradeName = Grades::select('nom')
            ->where('id', $presidentGrade)
            ->first();

        $examinateurGradeName = Grades::select('nom')
            ->where('id', $examinateurGrade)
            ->first();

        $gradeValues = [
            'Professeur' => 5,
            'Dr (MC)' => 4,
            'Dr (MA)' => 3,
            'Docteur' => 2,
            'Dr' => 2,
            'Ingénieur' => 1,
            'Ing' => 1,
        ];

        // $president = Professeurs::select('nom', 'prenom')
        //     ->where('id', $presidentId)
        //     ->first();
    
        // $examinateur = Professeurs::select('nom', 'prenom')
        //     ->where('id', $examinateurId)
        //     ->first();

        // Vérification de l'indisponibilité d'un enseignant dans un autre jury à la même heure
            $teacherConflict = Soutenance::where('jour', $jourSoutenance)
                ->where('horaire_id', $horaireId)
                ->where(function ($query) use ($presidentId, $examinateurId) {
                    $query->whereHas('jury', function ($subquery) use ($presidentId, $examinateurId) {
                        $subquery->where('president', $presidentId)
                            ->orWhere('examinateur', $examinateurId);
                    });
                })->count();
                
            // Si le nombre de soutenances pour ce jury atteint déjà 6, alors il y a conflit
            if ($teacherConflict == 6) {
                $enseignantConflict = Professeurs::find($presidentId);
                $nomEnseignant = $enseignantConflict->nom;
                $prenomEnseignant = $enseignantConflict->prenom;
                return redirect()->back()->withInput()->with('error', "Le professeur $nomEnseignant $prenomEnseignant est déjà assigné à un autre jury à la même heure.");
            }
        

        // Vérification de l'indisponibilité d'une salle pour un autre jury à la même heure
            $roomConflict = Soutenance::where('jour', $jourSoutenance)
                ->where('horaire_id', $horaireId)
                ->where('salle_id', $salleId)
                ->count();
        
            if ($roomConflict == 6) {
                $nomSalle = Salles::find($salleId)->nom;
                return redirect()->back()->withInput()->with('error', "La salle '$nomSalle' est déjà occupée pour un autre jury à la même heure.");
            }

        $errorFlag = false;
        $errorMessage = '';
    
        DB::transaction(function() use ($request, $jourSoutenance, $horaireId, $salleId, $sessionId, $presidentId, $examinateurId, $presidentGradeName, $examinateurGradeName, $gradeValues, &$errorFlag, &$errorMessage) {            
            foreach ($request->input('etudiant_id') as $etudiantId) {
                $etudiant = Etudiants::where('user_id', $etudiantId)->first();
                $getEtudiantId = Etudiants::where('user_id', $etudiantId)->value('id');
                if (!$etudiant) {
                    $errorFlag = true;
                    $errorMessage = 'Étudiant non trouvé';
                    break;
                }
    
                $existingJury = Jury::where('president', $presidentId)
                    ->where('examinateur', $examinateurId)
                    ->where('rapporteur', $etudiant->maitre_memoire)
                    ->first();
    
                if ($etudiant->maitre_memoire == $presidentId || $etudiant->maitre_memoire == $examinateurId) {
                    $errorFlag = true;
                    $errorMessage = 'Le professeur ' . $etudiant->professeur->prenom . ' ' . $etudiant->professeur->nom . 
                    ' est le maître mémoire de l\'étudiant ' . $etudiant->user->prenom . ' ' . $etudiant->user->nom . 
                    '. Les autres programmations ont été effectuées sauf pour l\'étudiant concerné.';
                    break;
                }
    
                if ($gradeValues[$presidentGradeName->nom] < $gradeValues[$examinateurGradeName->nom]) {
                    $errorFlag = true;
                    $errorMessage = 'Le grade du président doit être supérieur ou égal au grade de l\'examinateur.';
                    break;
                }
    
                $maitreMemoireId = $etudiant->maitre_memoire;
    
                if ($maitreMemoireId) {
                    $maitreMemoireGrade = Professeurs::where('id', $maitreMemoireId)->value('grade');
                    $maitreMemoireGradeName = Grades::select('nom')->where('id', $maitreMemoireGrade)->first();
    
                    if ($gradeValues[$presidentGradeName->nom] < $gradeValues[$maitreMemoireGradeName->nom]) {
                        $errorFlag = true;
                        $errorMessage = 'Le grade du président doit être supérieur ou égal au grade du maître de mémoire.';
                        break;
                    }
                }
    
                if ($existingJury) {
                    $juryId = $existingJury->id;
                } else {
                    $jury = new Jury();
                    $jury->president = $presidentId;
                    $jury->examinateur = $examinateurId;
                    $jury->rapporteur = $etudiant->maitre_memoire;
                    $jury->save();
                    $juryId = $jury->id;
                }
    
                $soutenance = new Soutenance();
                $soutenance->etudiant_id = $getEtudiantId;
                $soutenance->type = 'pre';
                $soutenance->jour = $jourSoutenance;
                $soutenance->jury_id = $juryId;
                $soutenance->session_id = $sessionId;
                $soutenance->horaire_id = $horaireId;
                $soutenance->salle_id = $salleId;
                $soutenance->state = 'pre';
                $soutenance->save();
    
                Etudiants::where('user_id', $etudiantId)->update(['is_ready' => 1]);
            }
    
            if (!$errorFlag) {
                $preSoutenanceCount = Soutenance::where('jour', $jourSoutenance)
                    ->where('session_id', $sessionId)
                    ->where('horaire_id', $horaireId)
                    ->where('salle_id', $salleId)
                    ->where('type', 'pre')
                    ->count();
    
                if ($preSoutenanceCount == 6) {
                    if ($horaireId == 1) {
                        AvailabilityRooms::where('jour', $jourSoutenance)
                            ->where('salle_id', $salleId)
                            ->where('session_id', $sessionId)
                            ->whereIn('deb_fin', ['H1', 'H2', 'H3', 'H4', 'H5'])
                            ->update(['occupe' => 1]);
    
                        AvailabilityTeachers::where('jour', $jourSoutenance)
                            ->where('prof_id', $examinateurId)
                            ->where('session_id', $sessionId)
                            ->whereIn('deb_fin', ['H1', 'H2', 'H3', 'H4', 'H5'])
                            ->update(['occupe' => 1]);
    
                        AvailabilityTeachers::where('jour', $jourSoutenance)
                            ->where('prof_id', $presidentId)
                            ->where('session_id', $sessionId)
                            ->whereIn('deb_fin', ['H1', 'H2', 'H3', 'H4', 'H5'])
                            ->update(['occupe' => 1]);
                    } else if ($horaireId == 2) {
                        AvailabilityRooms::where('jour', $jourSoutenance)
                            ->where('salle_id', $salleId)
                            ->where('session_id', $sessionId)
                            ->whereIn('deb_fin', ['H6', 'H7', 'H8', 'H9', 'H10'])
                            ->update(['occupe' => 1]);
    
                        AvailabilityTeachers::where('jour', $jourSoutenance)
                            ->where('prof_id', $examinateurId)
                            ->where('session_id', $sessionId)
                            ->whereIn('deb_fin', ['H6', 'H7', 'H8', 'H9', 'H10'])
                            ->update(['occupe' => 1]);
    
                        AvailabilityTeachers::where('jour', $jourSoutenance)
                            ->where('prof_id', $presidentId)
                            ->where('session_id', $sessionId)
                            ->whereIn('deb_fin', ['H6', 'H7', 'H8', 'H9', 'H10'])
                            ->update(['occupe' => 1]);
                    }
                }
            }
        });
    
        if ($errorFlag) {
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }
    
        return redirect()->route('etudiantPreSoutenance', ['session_id' => $sessionId])->with('success', 'Pré-soutenance(s) programmée(s) avec succès.');
    }
    public function enregistrerSoutenance(Request $request)
    {
        $request->validate([
            'jourSoutenance' => 'required',
            'horaire' => 'required',
            'salle' => 'required',
            'session' => 'required',
            'president' => 'required',
            'examinateur' => 'required',
            'rapporteur' => 'required',
        ], [
            'jourSoutenance' => 'Choisissez le jour de la soutenance',
            'horaire' => 'L\'horaire est important',
            'salle' => 'La salle est importante',
            'session' => 'La session est importante',
            'president' => 'Choisissez un président',
            'examinateur' => 'Choisissez un examinateur',
            'rapporteur' => 'Choisissez un rapporteur',
        ]);
    
        $etudiantId = $request->input('etudiantId');
        $typeSoutenance = $request->input('typeSoutenance');
        $jourSoutenance = $request->input('jourSoutenance');
        $horaireId = $request->input('horaire');
        $horaireNom = Horaires::where('id', $horaireId)->value('nom');
        $salleId = $request->input('salle');
        $sessionId = $request->input('session');
        
        $presidentId = $request->input('president');
        $examinateurId = $request->input('examinateur');
        $rapporteurId = $request->input('rapporteur');
    
        $sessions = Sessions::all('*');
        $sessionSelectionnee = Sessions::select('id','description', 'session_start', 'session_end')
        ->where('id', $sessionId)
        ->first();

        if ($sessionSelectionnee) {
            $idSess = $sessionSelectionnee->id;
            $description = $sessionSelectionnee->description;
            $debut = $sessionSelectionnee->session_start;
            $fin = $sessionSelectionnee->session_end;
        } else {
            return redirect()->back()->with('error', 'Session non trouvé');
        }
        $sout = Soutenance::where('state', 'soutenance')->where('session_id',$sessionId)->count();

        $existingJury = Jury::where('president', $presidentId)
            ->where('examinateur', $examinateurId)
            ->where('rapporteur', $rapporteurId)
            ->first();
    
        if ($existingJury) {
            $juryId = $existingJury->id;
        } else {
            $jury = new Jury();
            $jury->president = $presidentId;
            $jury->examinateur = $examinateurId;
            $jury->rapporteur = $rapporteurId;
            $jury->save();
            $juryId = $jury->id;
        }
            $state = 'soutenance';
    
        $soutenance = Soutenance::where('etudiant_id', $etudiantId)->first();
    
        // Vérifier la disponibilité des enseignants
        $professeursIds = [$presidentId, $examinateurId, $rapporteurId];

        foreach ($professeursIds as $professeurId) {
            $isProfAlreadyScheduled = AvailabilityTeachers::where('prof_id', $professeurId)
                ->where('type', 'sout')
                ->where('deb_fin', $horaireNom)
                ->where('jour', $jourSoutenance)
                ->where('occupe', 1)
                ->exists();

            if ($isProfAlreadyScheduled) {
                return back()->with('error', 'Un enseignant du jury est déjà programmé à la même heure et le même jour.');
            }
        }

        // Vérifier la disponibilité de la salle
        $isRoomAlreadyScheduled = AvailabilityRooms::where('salle_id', $salleId)
            ->where('type', 'sout')
            ->where('deb_fin', $horaireNom)
            ->where('jour', $jourSoutenance)
            ->where('occupe', 1)
            ->exists();

        if ($isRoomAlreadyScheduled) {
            return back()->with('error', 'La salle est déjà programmée à la même heure et le même jour.');
        }


        if ($soutenance) {

            $soutenance->jour = $jourSoutenance;
            $soutenance->type = 'sout';
            $soutenance->jury_id = $juryId;
            $soutenance->session_id = $sessionId;
            $soutenance->horaire_id = $horaireId;
            $soutenance->salle_id = $salleId;
            $soutenance->state = $state;
            Etudiants::where('id', $etudiantId)->update(['is_ready' => 3]);
            $soutenance->save();
        } else {
            $soutenance = new Soutenance();
            $soutenance->etudiant_id = $etudiantId;
            $soutenance->type = 'sout';
            $soutenance->jour = $jourSoutenance;
            $soutenance->jury_id = $juryId;
            $soutenance->session_id = $sessionId;
            $soutenance->horaire_id = $horaireId;
            $soutenance->salle_id = $salleId;
            $soutenance->state = $state;
            $soutenance->save();
        }

        AvailabilityTeachers::whereIn('prof_id', $professeursIds)
            ->where('type', 'sout')
            ->where('deb_fin', $horaireNom)
            ->where('jour', $jourSoutenance)
            ->update(['occupe' => 1]);

        AvailabilityRooms::where('salle_id', $salleId)
            ->where('type', 'sout')
            ->where('deb_fin', $horaireNom)
            ->where('jour', $jourSoutenance)
            ->update(['occupe' => 1]);

        $etudiants = Etudiants::whereNotNull('file')
            ->whereNotNull('theme')
            ->get();
    
        // return view('AdminPages.EnSoutenance', compact('etudiants'));
        return view('AdminPages.EnSoutenance', compact('etudiants','sessions','description','debut','fin','sout'))->with('success', 'Soutenance programmée avec succès');

    }
    public function docPDF($filename)
    {
        $filePath = public_path('uploads/' . $filename);
    
        if (file_exists($filePath)) {
            $headers = [
                'Content-Type' => 'application/pdf',
            ];
    
            return response()->file($filePath, $headers);
        } else {
            abort(404, 'PDF not found');
        }
    }
    
}
