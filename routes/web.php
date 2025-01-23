<?php

use App\Http\Controllers\ImportController;
use App\Http\Controllers\EtudiantsController;
use App\Http\Controllers\ProfesseursController;
use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\GeneralesController;
use App\Http\Controllers\DisponibilitesController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\AdminPagesController;
use App\Http\Controllers\ProgrammationController;
use App\Http\Controllers\ProgrammesController;
use App\Http\Controllers\PdfController;
use App\Models\Etudiants;
use App\Models\Horaires;
use App\Models\Professeurs;
use App\Models\Sessions;
use App\Models\Salles;
use App\Models\Soutenance;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Mail;


Route::get('/send-email', function () {
    Mail::raw('Ceci est un test avec Mailpit', function ($message) {
        $message->from('no-reply@example.com', 'DefenseScheduler')
                ->to('recipient@example.com') // Utilise une adresse générique
                ->subject('Test Mailpit');
    });

    return 'E-mail envoyé avec succès !';
});



Route::withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->group(function () {
    Route::post('/addDisponibiliteEnseignant', [DisponibilitesController::class, 'AddDisponibiliteProfesseur'])->name('addDisponibiliteEnseignant');
});

Route::get('/check-session-name', [SessionController::class, 'checkSessionName'])->name('checkSessionName');

    //PDF
    Route::controller(PdfController::class)->group(function(){
        Route::get('/quittancePdf','quittancePdf')->name('quittancePdf');
        Route::get('/invitation','invitation')->name('invitation');
    });
    //Route::get('/showPlanning', [OptimisationController::class, 'index'])->name('showPlanning');


    //connexion
    Route::controller(ConnexionController::class)->group(function(){
        Route::get('/','loginView')->name('login');
        Route::get('/deconnexion','deconnexion')->name('deconnexion');
        Route::post('/loginUser','login')->name('loginUser');
    });

    Route::controller(EtudiantsController::class)->group(function(){

        Route::post('/changePassword','ChangePassword')->name('changePassword');


    });
   
    
    Route::get('/formulaire', [EtudiantsController::class, 'afficherFormulaire'])->name('afficherFormulaire');
    Route::controller(ProgrammationController::class)->group(function(){
        Route::get('/pdf/{filename}','docPDF')->name('docPDF');
    });

    Route::middleware(['auth:user', 'role:0'])->group(function () {
        Route::get('/StudentsDashboard',[ConnexionController::class,'StudentsDashboard'])->name('StudentsDashboard');
        Route::get('/TeacherDasboard',[ConnexionController::class,'TeacherDasboard'])->name('TeacherDasboard');

        Route::post('/infosStudents',[EtudiantsController::class,'infosStudents'])->name('infosStudents');

    });
    Route::middleware(['auth:user', 'role:2'])->group(function () {
      Route::get('/TeacherDasboard',[ConnexionController::class,'TeacherDashboard'])->name('TeacherDasboard');

    });

    Route::middleware(['auth:user', 'role:1'])->group(function () {

        Route::get('/choiceSession', [AdminPagesController::class, 'choiceSession'])->name('choiceSession');
        Route::post('/nommerAdmin', [AdminPagesController::class, 'nommerAdmin'])->name('nommerAdmin');
        Route::get('/AdminDashboard/{session_id}', [AdminPagesController::class, 'infos'])->name('infos');
        Route::get('/infosSoutenances', [AdminPagesController::class, 'infosSoutenances'])->name('infosSoutenances');
        Route::get('/etudiants/{etudiantId}', [AdminPagesController::class, 'getEtudiantData'])->name('getEtudiantData');
        Route::get('/horaires/{horaireId}', [AdminPagesController::class, 'getHoraireData'])->name('getHoraireData');
        Route::get('/generatePgWJury', [AdminPagesController::class, 'generatePgWJury'])->name('generatePgWJury');

        /**
        * Etudiants
        */
        Route::controller(EtudiantsController::class)->group(function(){
            Route::get('/Etudiant','ShowStudents')->name('etudiant');
            Route::post('/ajoutEtudiant','AddStudents')->name('ajoutEtudiant');
            Route::post('/etudiants/{id}','UpdateStudents')->name('updateEtudiant');
            Route::delete('/etudiant/{id}', 'DeleteStudents')->name('deleteEtudiant');
            Route::post('/update-etudiant-status','updateStatus')->name('updateStatusStudent');
            Route::post('/update-all-etudiants-status','updateAllEtudiantsStatus')->name('updateAllEtudiantsStatus');
        });
        /**
         * Professeurs
         */

        Route::controller(ImportController::class)->group(function(){
            Route::post('/importTeachers','importTeachers')->name('importTeachers');
            Route::post('/import','import')->name('import');
        });

        Route::controller(ProfesseursController::class)->group(function(){
            Route::get('/Enseignant','ShowTeachers')->name('professeur');
            Route::post('/ajoutProfesseur','AddTeachers')->name('ajoutProfesseur');
            Route::post('/professeurs/{id}','UpdateTeachers')->name('updateEnseignant');
            Route::delete('/professeur/{id}', 'DeleteTeachers')->name('deleteProfesseur'); // Ensure this is DELETE

        });

        /**
         * Grades
         */
        Route::controller(GradesController::class)->group(function(){
            Route::get('/GradeEnseignant','ShowGrades')->name('gradesProf');
            Route::post('/ajoutGrades','AddGrades')->name('ajoutGrades');
            Route::post('/gradeUpdate', 'UpdateGrades')->name('gradeUpdate');
            Route::post('/gradeDelete', 'DeleteGrades')->name('gradeDelete');

        });
        /**
         * Générales : Horaires, Salles, Sessions,Specilité
         */
        Route::controller(GeneralesController::class)->group(function(){
            Route::get('/Settings/{session_id}','ShowInfos')->name('infoSettings');
            Route::post('/sessionAdd', 'AddSessions')->name('sessionAdd');
            Route::post('/horaireAdd', 'AddHoraires')->name('horaireAdd');
            Route::post('/salleAdd', 'AddSalles')->name('salleAdd');
            Route::post('/salleUpdate', 'UpdateSalles')->name('salleUpdate');
            Route::post('/sessUpdate', 'UpdateSession')->name('sessUpdate');
            Route::get('/sessions/{session_id}','destroy')->name('deleteSession');
            Route::post('/specialite/delete',  'destroySpeciality')->name('specialiteDelete');
            Route::post('/specialite/add', 'storeSpeciality')->name('specialiteAdd');
            Route::post('/specialite/update','updateSpeciality')->name('specialiteUpdate');
        });

        /**
        * Disponibilité
        */
        Route::controller(DisponibilitesController::class)->group(function(){
            /**
             * Disponibilite enseignants
             */
            Route::get('/DisponibiliteEnseignant/{session_id}','Disponibilite')->name('disponibilite');
            //Route::post('/addDisponibiliteEnseignant', 'AddDisponibiliteProfesseur')->name('adDisponibiliteEnseignant');
            Route::get('/disponibilite/{id}', 'DeleteDispo')->name('deleteDispo');
            Route::post('/dispoProfsEmpty', 'dispoProfsEmpty')->name('dispoProfsEmpty');
            Route::post('/dispoMailProf','dispoMailProf')->name('dispoMailProf');

            /**
             * Disponibilite salles
             */
            Route::get('/DisponibiliteSalle/{session_id}','DisponibiliteSalle')->name('disponibiliteSalle');
            Route::post('/addDisponibiliteSalle', 'AddDisponibiliteSalle')->name('addDisponibiliteSalle');
            Route::get('/disponibiliteSalle/{id}', 'DeleteDispoSalle')->name('deleteDispoSalle');
            Route::post('/dispoSallesEmpty', 'dispoSallesEmpty')->name('dispoSallesEmpty');

        });

        /**
         * Programmation
         */
        Route::controller(ProgrammationController::class)->group(function(){
            Route::get('/ProgrammationSoutenance/{id}', 'StudentsInfos')->name('StudentsInfos');
            Route::get('/ProfesseursDisponibles', 'ProfesseursDisponibles')->name('ProfesseursDisponibles');
            Route::get('/SallesDisponibles', 'SallesDisponibles')->name('SallesDisponibles');
            Route::get('/ProfesseursNames', 'ProfesseursNames')->name('ProfesseursNames');
            Route::get('/SallesNames', 'SallesNames')->name('SallesNames');
            Route::post('/programmerSoutenance', 'enregistrerSoutenance')->name('programmerSoutenance');
            Route::post('/programmerPreSoutenance', 'enregistrerPreSoutenance')->name('programmerPreSoutenance');
            //Route::get('/EnSoutenance/{session_id}','ShowStudentsEnSout')->name('etudiantSoutenance');
            Route::get('/PreSoutenance/{session_id}','preSout')->name('etudiantPreSoutenance');
            Route::get('/EnSoutenance/{session_id}','Sout')->name('etudiantSoutenance');
            //Route::get('/pagePreSoutProg/{session_id}','preSoutProg')->name('preSoutProg');
            Route::get('/getStudentsBySession/{sessionId}', 'getStudentsBySession')->name('getStudentsBySession');
            Route::get('/getStudentsSoutBySession/{sessionId}', 'getStudentsSoutBySession')->name('getStudentsSoutBySession');
            Route::get('/horaires-disponibles/{date}', 'getHorairesDisponibles')->name('horaires-disponibles');


        });

        /**
         * Programme pré soutenance
         */
        Route::controller(ProgrammesController::class)->group(function () {
            Route::get('/pre-soutenance/{idSess}/{type}', 'pgpreSout')->name('pgpreSout');
            // Route::get('/pgDetaille/{idSess}','pgDetaille')->name('pgDetaille');
            Route::post('/programmeSendEtudiants','programmeSendEtudiants')->name('programmeSendEtudiants');
            Route::get('/programmeSendEnseignants/{idSess}/{type}/{year}/{month}', 'programmeSendEnseignants')->name('programmeSendEnseignants');
            Route::get('/generate-invitations/{sessionId}', 'generateInvitations')->name('generate.invitations');
            Route::get('/generate-pv/{sessionId}', 'generatePvs')->name('generate.pvs');
        });



        Route::get('/preSoutenancePdf/{idSess}/{type}', function ($idSess, $type) {
            $soutenances = Soutenance::where('state', $type)
                ->where('session_id', $idSess)
                ->orderBy('jour', 'asc') // Ordonne par date croissante
                ->with('etudiant.user', 'session', 'salle', 'horaire', 'jury')
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
                // Filtrer les soutenances du jury à la même heure dans la même salle
                $filteredSoutenances = $soutenancesExaminateurPresident->filter(function ($soutenance) use ($soutenancesExaminateurPresident) {
                    return $soutenance->horaire_id === $soutenancesExaminateurPresident[0]->horaire_id
                        && $soutenance->salle_id === $soutenancesExaminateurPresident[0]->salle_id
                        && $soutenance->jour === $soutenancesExaminateurPresident[0]->jour;
                });
                $filieresParExaminateurPresident[$examinateurPresidentHoraireSalle] = $filteredSoutenances->pluck('etudiant.filiere')->unique()->values();
            }

            // $professeurs = Professeurs::all('*');
            // $nombreTotalEtudiants = User::where('role', 0)->count();
            // $nombreTotalEtudiantsEnPre = Etudiants::where('is_ready', 1)->count();
            // $nombreTotalEtudiantsEnSout = Etudiants::where('is_ready', 3)->count();
            // $nombreTotalProfesseurs = Professeurs::count();
            // $sessions = Sessions::all('*');

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
            $pdfController = new PdfController();
            return $pdfController->preSoutenancePdf($idSess, $type, $soutenancesGroupedByExaminateurPresident, $filieresParExaminateurPresident, $value, $month, $year);
        });

        Route::get('/preSoutenancePdfAvecJury/{idSess}/{type}', function ($idSess, $type) {
            $soutenances = Soutenance::where('state', $type)
                ->where('session_id', $idSess)
                ->orderBy('jour', 'asc') // Ordonne par date croissante
                ->with('etudiant.user', 'session', 'salle', 'horaire', 'jury')
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
            $pdfController = new PdfController();
            return $pdfController->preSoutenancePdfAvecJury($idSess, $type, $soutenancesGroupedByExaminateurPresident, $filieresParExaminateurPresident, $value, $month, $year);
        });

        Route::get('/soutenancePdf/{idSess}/{type}', function ($idSess, $type) {

            $soutenances = Soutenance::where('type', $type)
            ->where('session_id', $idSess)
            ->orderBy('jury_id', 'asc')
            ->orderBy('jour', 'asc')
            ->orderBy('horaire_id', 'asc')
            ->with('etudiant.user', 'session', 'salle', 'horaire', 'jury')
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
            $pdfController = new PdfController();
            return $pdfController->soutenancePdf($idSess, $type, $soutenances, $value, $month, $year);
        });

        Route::get('/soutenancePdfAvecJury/{idSess}/{type}', function ($idSess, $type) {


            $soutenances = Soutenance::where('type', $type)
            ->where('session_id', $idSess)
            ->orderBy('jury_id', 'asc')
            ->orderBy('jour', 'asc')
            ->orderBy('horaire_id', 'asc')
            ->with('etudiant.user', 'session', 'salle', 'horaire', 'jury')
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
            $pdfController = new PdfController();
            return $pdfController->soutenancePdfAvecJury($idSess, $type, $soutenances, $value, $month, $year);
        });

        Route::get('/pgDetaille/{idSess}', function ($idSess){
            $professeurs = Professeurs::all('*');
            $session = Sessions::find($idSess);
            $salles = Salles::all('*');
            $horaires = Horaires::all('*');

            if (!$session) {
                return abort(404);
            }

            $sessionStart = $session->session_start;
            $sessionEnd = $session->session_end;

            $nombreDeJours = Carbon::parse($sessionEnd)->diffInDays($sessionStart) + 1;

            // Récupérer les soutenances triées par jour et heure
            $soutenances = Soutenance::where('session_id', $idSess)
                ->where('type','sout')
                ->with('jury', 'salle', 'horaire')
                ->orderBy('jour')
                ->orderBy('horaire_id') // Assuming 'horaire_id' corresponds to the 'heure'
                ->get();

            $programmation = [];


            foreach ($soutenances as $soutenance) {
                $jury = $soutenance->jury;
                $jour = $soutenance->jour;
                $heure = $soutenance->horaire->nom;
                $salleId = $soutenance->salle_id;
                $salle = $soutenance->salle->nom;

                foreach (['president', 'examinateur', 'rapporteur'] as $role) {
                    $enseignant = $jury->{$role . 's'};

                    if ($enseignant && !isset($programmation[$enseignant->id])) {
                        $programmation[$enseignant->id] = [
                            'nom' => $enseignant->nom,
                            'prenom' => $enseignant->prenom,
                            'role' => $role,
                            'programmation' => [],
                        ];
                    }

                    if (isset($programmation[$enseignant->id])) {
                        $programmation[$enseignant->id]['programmation'][] = [
                            'jour' => $jour,
                            'heure' => $heure,
                            'salleId' => $salleId,
                            'salle' => $salle,
                        ];
                    }
                }
            }

            // // Filtrer pour enlever les jours sans programmation
            // foreach ($programmation as &$enseignant) {
            //     $enseignant['programmation'] = array_filter($enseignant['programmation'], function($prog) {
            //         return !empty($prog['jour']);
            //     });
            // }

            $pdfController = new PdfController();
            return $pdfController->pgDetaillePdf($professeurs, $salles, $horaires, $session, $nombreDeJours, $programmation);
        });

        Route::get('/pgByEns/{idSess}', function ($idSess) {
            $professeurs = Professeurs::all('*');
            $session = Sessions::find($idSess);
            $salles = Salles::all('*');
            $horaires = Horaires::all('*');

            if (!$session) {
                return abort(404);
            }

            $sessionStart = $session->session_start;
            $sessionEnd = $session->session_end;

            $nombreDeJours = Carbon::parse($sessionEnd)->diffInDays($sessionStart) + 1;

            $soutenances = Soutenance::where('session_id', $idSess)
                ->where('type', 'sout')
                ->with('jury', 'salle', 'etudiant', 'horaire')
                ->orderBy('jour')
                ->orderBy('horaire_id')
                ->get();

            $programmation = [];

            foreach ($soutenances as $soutenance) {
                $jury = $soutenance->jury;
                $jour = $soutenance->jour;
                $heureDebut = Carbon::parse($soutenance->horaire->debut)->format('H\H');
                $heureFin = Carbon::parse($soutenance->horaire->fin)->format('H\H');
                $heure = $heureDebut . ' - ' . $heureFin;
                $salleId = $soutenance->salle_id;
                $salle = $soutenance->salle->nom;
                $etudiant = $soutenance->etudiant->user->nom . ' ' . $soutenance->etudiant->user->prenom . ' ( ' . $soutenance->etudiant->theme . ' ) ';

                foreach (['president', 'examinateur', 'rapporteur'] as $role) {
                    $enseignant = $jury->{$role . 's'};

                    if ($enseignant && !isset($programmation[$enseignant->id])) {
                        $programmation[$enseignant->id] = [
                            'nom' => $enseignant->nom,
                            'prenom' => $enseignant->prenom,
                            'programmation' => [],
                        ];
                    }

                    if (isset($programmation[$enseignant->id])) {
                        $programmation[$enseignant->id]['programmation'][] = [
                            'jour' => $jour,
                            'heure' => $heure,
                            'salleId' => $salleId,
                            'role' => $role,
                            'salle' => $salle,
                            'etudiant' => $etudiant,
                        ];
                    }
                }
            }

            // Sort professors by last name
            usort($programmation, function ($a, $b) {
                return strcmp($a['nom'], $b['nom']);
            });

            $pdfController = new PdfController();
            return $pdfController->pgEnsPdf($professeurs, $salles, $horaires, $session, $nombreDeJours, $programmation);
        });

        Route::get('/pgByRooms/{idSess}', function ($idSess) {
            $session = Sessions::find($idSess);
            $salles = Salles::all('*');
            $horaires = Horaires::all('*');

            if (!$session) {
                return abort(404);
            }

            $sessionStart = $session->session_start;
            $sessionEnd = $session->session_end;

            $nombreDeJours = Carbon::parse($sessionEnd)->diffInDays($sessionStart) + 1;

            $soutenances = Soutenance::where('session_id', $idSess)
                ->where('type', 'sout')
                ->with('jury', 'salle', 'etudiant', 'horaire')
                ->orderBy('jour')
                ->orderBy('horaire_id')
                ->get();

            $programmation = [];

            foreach ($soutenances as $soutenance) {
                $jury = $soutenance->jury;
                $jour = $soutenance->jour;
                $heureDebut = Carbon::parse($soutenance->horaire->debut)->format('H\H');
                $heureFin = Carbon::parse($soutenance->horaire->fin)->format('H\H');
                $heure = $heureDebut . ' - ' . $heureFin;
                $salleId = $soutenance->salle_id;
                $salle = $soutenance->salle->nom;
                $etudiant = $soutenance->etudiant->user->nom . ' ' . $soutenance->etudiant->user->prenom . ' ( ' . $soutenance->etudiant->theme . ' ) ';

                if (!isset($programmation[$salleId])) {
                    $programmation[$salleId] = [
                        'salle' => $salle,
                        'soutenances' => []
                    ];
                }

                $juryDetails = [];
                foreach (['president', 'examinateur', 'rapporteur'] as $role) {
                    $enseignant = $jury->{$role . 's'};
                    if ($enseignant) {
                        $juryDetails[] = ucfirst($role) . ': ' . $enseignant->gradeProfesseur->nom. ' '. $enseignant->prenom . ' ' . $enseignant->nom;
                    }
                }

                $programmation[$salleId]['soutenances'][] = [
                    'jour' => $jour,
                    'heure' => $heure,
                    'etudiant' => $etudiant,
                    'jury' => implode(', ', $juryDetails),
                ];
            }

            // Sort by salle name
            usort($programmation, function ($a, $b) {
                return strcmp($a['salle'], $b['salle']);
            });

            $pdfController = new PdfController();
            return $pdfController->pgSallePdf($salles, $horaires, $session, $nombreDeJours, $programmation);
        });


    });


