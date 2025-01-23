<?php
 
namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use App\Models\Etudiants;
use App\Models\Professeurs;
use App\Models\Salles;
use App\Models\Soutenance;
use App\Models\Sessions;
use App\Models\Speciality;
use App\Models\Grades;
use App\Models\User;
use App\Models\Horaires;
use App\Models\Jury;
use App\Models\AvailabilityTeachers;
use App\Models\AvailabilityRooms;
use App\Http\Requests\RunOptimizationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PlanningNotification;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;



 
class OptimisationController extends Controller
{
     /**
     * Préparer les données pour Flask.
     */
    private function prepareData(Request $request)
    {
        // Récupérer l'ID de la session depuis la requête
        $session_id = $request->input('session_id');
        // Récupérer le type de soutenance depuis la session
        $type_soutenance = $request->input('type');; // Assurez-vous que le champ existe dans la table "sessions"
        $choix_heuristique = $request->input('choix_heuristique');; // Assurez-vous que le champ

        if (!$session_id) {
            return response()->json(['error' => 'Session ID is required.'], status: 400);
        }

        // Récupérer la session correspondante à cet ID
        $session = Sessions::find($session_id);

        if (!$session) {
            return response()->json(['error' => 'Session not found.'], 404);
        }

        if ($type_soutenance == "Pre-Soutenance"){
            $etudiants = Etudiants::where('is_ready', 2)->get(); //Tous les étudiants qui sont prêt pour passer au planning
        }

        if ($type_soutenance == "Soutenance"){
            $etudiants = Etudiants::where('is_ready', 4)->get(); //Tous les étudiants qui sont prêt pour passer au planning
        }
        $professeurs = Professeurs::all();
        $specialities = Speciality::all();
        $salles = Salles::all();
        $grades = Grades::all();
         // Récupérer les disponibilités des enseignants pour la session et le type de soutenance
        $availabilityteachers = AvailabilityTeachers::where('session_id', $session_id)
        ->where('type_soutenance', $type_soutenance) // Filtrer par type de soutenance
        ->get();

        // Récupérer les disponibilités des salles pour la session et le type de soutenance
        $availabilityroom = AvailabilityRooms::where('session_id', $session_id)
            ->where('type_soutenance', $type_soutenance) // Filtrer par type de soutenance
            ->get();

        $horaire = Horaires::where('nom', 'like', 'L%')
        ->orderBy('debut')
        ->get()
        ->map(function ($horaire) {
            return [
                'id' => $horaire->id,
                'debut' => $horaire->debut,
                'fin' => $horaire->fin
            ];
        })
        ->toArray();
    

        // Récupérer et trier les plages horaires pour les licences (L)
        $plages_horaires_L = Horaires::where('nom', 'like', 'L%') // Filtrer uniquement les horaires des licences
            ->orderBy('debut') // Trier par heure de début
            ->get()
            ->map(function ($horaire) {
                return $horaire->debut . ' - ' . $horaire->fin;
            })
            ->toArray();

        // Récupérer et trier les plages horaires pour les masters (M)
        $plages_horaires_M = Horaires::where('nom', 'like', 'M%') // Filtrer uniquement les horaires des masters
            ->orderBy('debut') // Trier par heure de début
            ->get()
            ->map(function ($horaire) {
                return $horaire->debut . ' - ' . $horaire->fin;
            })
            ->toArray();



        // Préparer les données à envoyer au service Flask
        $data = [
            'etudiants' => $etudiants,
            'professeurs' => $professeurs,
            'specialities' => $specialities,
            'salles' => $salles,
            'grades' => $grades,
            'session' => $session,
            'session_id' => $session_id, 
            'type_soutenances' => $type_soutenance,
            'horaire' => $horaire,
            'plages_horaires_L' => $plages_horaires_L,
            'plages_horaires_M' => $plages_horaires_M,
            'availabilityteachers' => $availabilityteachers,
            'availabilityroom' => $availabilityroom,
            'choix_heuristique' => $choix_heuristique,
        ];
        return $data;
    }

        /* 
                        public function index(Request $request)
                        {

                            try {
                                // Récupérer l'ID de la session depuis la requête
                                $session_id = $request->input('session_id');
                                // Récupérer le type de soutenance depuis la session
                                $type_soutenance = $request->input('type_soutenance');; // Assurez-vous que le champ existe dans la table "sessions"

                                if (!$session_id) {
                                    return response()->json(['error' => 'Session ID is required.'], 400);
                                }

                                // Récupérer la session correspondante à cet ID
                                $session = Sessions::find($session_id);

                                if (!$session) {
                                    return response()->json(['error' => 'Session not found.'], 404);
                                }

                            
                                $etudiants = Etudiants::where('is_ready', 1)->get(); //Tous les étudiants qui sont prêt pour passer au planning
                                $professeurs = Professeurs::all();
                                $specialities = Speciality::all();
                                $salles = Salles::all();
                                $grades = Grades::all();
                                // Récupérer les disponibilités des enseignants pour la session et le type de soutenance
                                $availabilityteachers = AvailabilityTeachers::where('session_id', $session_id)
                                ->where('type_soutenance', $type_soutenance) // Filtrer par type de soutenance
                                ->get();

                                // Récupérer les disponibilités des salles pour la session et le type de soutenance
                                $availabilityroom = AvailabilityRooms::where('session_id', $session_id)
                                    ->where('type_soutenance', $type_soutenance) // Filtrer par type de soutenance
                                    ->get();

                                // Récupérer et trier les plages horaires pour les licences (L)
                                $plages_horaires_L = Horaires::where('nom', 'like', 'L%') // Filtrer uniquement les horaires des licences
                                    ->orderBy('debut') // Trier par heure de début
                                    ->get()
                                    ->map(function ($horaire) {
                                        return $horaire->debut . ' - ' . $horaire->fin;
                                    })
                                    ->toArray();

                                // Récupérer et trier les plages horaires pour les masters (M)
                                $plages_horaires_M = Horaires::where('nom', 'like', 'M%') // Filtrer uniquement les horaires des masters
                                    ->orderBy('debut') // Trier par heure de début
                                    ->get()
                                    ->map(function ($horaire) {
                                        return $horaire->debut . ' - ' . $horaire->fin;
                                    })
                                    ->toArray();

                        

                                // Préparer les données à envoyer au service Flask
                                $data = [
                                    'etudiants' => $etudiants,
                                    'professeurs' => $professeurs,
                                    'salles' => $salles,
                                    'specialities' => $specialities,
                                    'grades' => $grades,
                                    'session' => $session,
                                    'plages_horaires_L' => $plages_horaires_L,
                                    'plages_horaires_M' => $plages_horaires_M,
                                    'availabilityteachers' => $availabilityteachers,
                                    'availabilityroom' => $availabilityroom,
                                ];
                        
                                // Retourner la réponse de Flask
                                return response()->json($data);
                            } catch (\Exception $e) {
                                // Gérer les erreurs
                                return response($e);
                            }
                        }
                            
                                public function runFlask(Request $request)
                                {
                                    try {
                                        // Récupérer les données nécessaires
                                        
                                        $data = $this->prepareData($request);
                            
                                        // Envoyer les données au service Flask
                                        $response = Http::post('http://127.0.0.1:5000/generate_planning', $data);

                                        $plannings = $response['plannings'] ?? [];
                                    
                                        
                                        return response()->json($plannings, 200, [], JSON_UNESCAPED_UNICODE);
                            
                                        // Vérifier si l'appel à Flask a réussi
                                        if ($response->successful()) {
                                            return $this->$response->json();
                                        } else {
                                            return $this->handleError(
                                                'Erreur lors de la communication avec Flask.',
                                                $response->body(),
                                                $response->status()
                                            );
                                        }
                                    } catch (\Exception $e) {
                                        // Gérer les exceptions côté Laravel
                                        return $this->handleError('Une erreur inattendue est survenue.', $e->getMessage(), 500);
                                    }
                                }
        */

        /*
                // Méthode pour démarrer le serveur Flask directement
                private function startFlaskServer()
                {
                    // Chemin complet vers le script Python
                    $pythonScript = 'app\Http\Controllers\Api\flask_api.py';
                    
                    // Commande pour exécuter le script Flask
                    $command = "python3 $pythonScript > /dev/null 2>&1 &";

                    // Exécution du script Flask
                    exec($command, $output, $returnVar);

                    if ($returnVar === 0) {
                        Log::info("Le serveur Flask a été démarré avec succès.");
                    } else {
                    Log::error("Erreur lors du démarrage de Flask. Code de retour : $returnVar");
                    }
                }  

                private function startFlaskServer()
                    {
                        // Définit le chemin complet vers le fichier Python
                        $scriptPath = base_path("app/Http/Controllers/Api/modules/checkAndStartFlask.py");
                    
                        // Chemin absolu de Python
                        $pythonPath = "C:/Users/mammo/AppData/Local/Programs/Python/Python312/python.exe";
                    
                        // Définit la commande à exécuter avec l'interpréteur Python
                        $command = "$pythonPath $scriptPath";  // Note l'espace après python.exe
                        Log::info("Commande exécutée : " . $command);

                        //shell_exec($command);
                        // Exécuter la commande
                        shell_exec($command);

                    
                    }
        */
        


    public function runFlask(Request $request)
    {
        try {
            
            // Préparer les données pour l'API Flask
            $data = $this->prepareData($request);

            // Appeler l'API Flask
            $response = Http::post('http://127.0.0.1:5000/generate_planning', $data);
            
            // Vérifier la réponse de Flask
            if ($response->successful() && isset($response['plannings'])) {
            
                return $response->json(); // Retourner les données JSON décodées
            
            } else {
                // Gérer les erreurs côté Flask
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la génération du planning.',
                    'details' => $response->json() ?? 'Aucune réponse valide reçue de Flask.'
                ], 500);
            }
        } catch (\Exception $e) {
            // Gérer les erreurs côté Laravel
            return response()->json([
                'success' => false,
                'message' => 'Une erreur inattendue est survenue.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    
    /**
     * Afficher le planning généré.
     */
    public function runPlanning(Request $request)
    {
    
        try {
            
            // Appeler la méthode Flask via la méthode runFlask()
            $response = $this->runFlask($request);
            

           // $data = $this->prepareData($request);
                
            // Décoder la réponse JSON si elle n'est pas encore un tableau PHP
            $data = $response instanceof JsonResponse ? $response->getData(true) : $response;
            
            $plannings = $data['plannings'];
            
          
            // Vérifier si la réponse a réussi
            if ($data['success']) {
                
                $soutenances = $data['plannings']['soutenances'] ?? [];
                $metrics = $data['plannings']['metrics'] ?? [];
                $type = $data['plannings']['type'] ?? 'Inconnu';


                foreach ($soutenances as $jour => &$soutenances_jour){       
                    foreach ($soutenances_jour as &$soutenance){
                        // Récupérer l'étudiant
                        $student = Etudiants::find($soutenance['etudiant_id']);
                        $theme = $student->theme;
                        $etudiant = User::where('id', $student->user_id)->first();
                        $soutenance['etudiant_nom'] = $etudiant ? $etudiant->prenom . ' ' . $etudiant->nom : 'Inconnu';
                        $soutenance['theme'] =$theme ;
                        $salles = Salles::find($soutenance['salle_id']);
                        $soutenance['salle_nom'] = $salles ? $salles->nom : 'Inconnu';
                        
                        // Récupérer les membres du jury dans la table Professeur
                        $jury_president = Professeurs::find($soutenance['president']);
                        $jury_examinateur = Professeurs::find($soutenance['examinateur']);
                        $jury_rapporteur = Professeurs::find($soutenance['rapporteur']);
                       
                        $soutenance['president_nom'] = $jury_president ? User::where('id', $jury_president->user_id)->first()->nom ?? 'Inconnu' : 'Inconnu';
                        $soutenance['examinateur_nom'] =  $jury_examinateur ? User::where('id', $jury_examinateur->user_id)->first()->nom ?? 'Inconnu' : 'Inconnu';
                        $soutenance['rapporteur_nom'] = $jury_rapporteur ? User::where('id', $jury_rapporteur->user_id)->first()->nom ?? 'Inconnu' : 'Inconnu';
                        
                        
                    }
                }
               
                $problemes = $data['plannings']['probleme'] ?? [];
                $names = []; // Initialiser un tableau pour stocker les noms
                
                foreach ($problemes as $probleme) {
                    $student = Etudiants::find($probleme);
                    if ($student) { // Vérifiez si l'étudiant existe
                        $etudiant = User::where('id', $student->user_id)->first();
                        if ($etudiant) { // Vérifiez si l'utilisateur existe
                            $names[] = $etudiant->prenom . ' ' . $etudiant->nom; // Ajouter nom complet
                        }
                    }
                }
       
                $selectedSessionId = $request->session_id;
                 return view('planning.showplanning', compact('plannings', 'soutenances', 'metrics', 'type', 'names','selectedSessionId'));

              
                
            } else {
                // Gestion des erreurs spécifiques
                
                return view('AdminPages\PreSoutenanceList', [
                    'error' => $data['message'] ?? 'Une erreur est survenue.',
                ]);
            }

        } catch (\Exception $e) {
            // Gestion des erreurs inattendues
            
            return redirect()->back()->with('error', 'Erreur trouvé');
        }
            
    }
 public function ModifierPlanning(Request $request)
 {
                // ID de la session
            $selectedSessionId = $request-> session_id;
            $type = $request-> type;
           
            $session = Sessions::findOrFail($selectedSessionId);

            // Déterminer les dates de début et de fin
            $startDate = null;
            $endDate = null;

            if ($type === 'Pre-Soutenance') {
                $startDate = Carbon::parse($session->session_start_PreSout);
                $endDate = Carbon::parse($session->session_end_PreSout);
            } elseif ($type === 'Soutenance') {
                $startDate = Carbon::parse($session->session_start_Sout);
                $endDate = Carbon::parse($session->session_end_Sout);
            } else {
                return redirect()->back()->with('error', 'Type de session invalide.');
            }

            // Générer les jours entre la date de début et la date de fin
            $days = [];
            while ($startDate->lte($endDate)) {
                $days[] = $startDate->toDateString();
                $startDate->addDay();
            }

            
            $soutenances = Soutenance::where('session_id', $selectedSessionId)
            ->where('type', $type)
            ->get()
            ->groupBy('jour'); // Regrouper par le champ "jour"
            
            foreach ($soutenances as $jour => &$soutenances_jour){       
                foreach ($soutenances_jour as &$soutenance){
                    // Récupérer l'étudiant
                    
                    $student = Etudiants::find($soutenance['etudiant_id']);
                    $theme = $student->theme;
                    $etudiant = User::where('id', $student->user_id)->first();
                    $soutenance['etudiant_nom'] = $etudiant ? $etudiant->prenom . ' ' . $etudiant->nom : 'Inconnu';
                    $soutenance['theme'] =$theme ;
                    $salles = Salles::find($soutenance['salle_id']);
                    $soutenance['salle_nom'] = $salles ? $salles->nom : 'Inconnu';
                    $jury = Jury::find($soutenance['jury_id']);
                    // Récupérer les membres du jury dans la table Professeur
                    $jury_president = Professeurs::find($jury['president']);
                    $jury_examinateur = Professeurs::find($jury['examinateur']);
                    $jury_rapporteur = Professeurs::find($jury['rapporteur']);
                    $soutenance['president'] = $jury['president'];
                    $soutenance['examinateur'] = $jury['examinateur'];
                    $soutenance['rapporteur'] = $jury['rapporteur'];
                    $soutenance['president_nom'] = $jury_president ? User::where('id', $jury_president->user_id)->first()->nom ?? 'Inconnu' : 'Inconnu';
                    $soutenance['examinateur_nom'] =  $jury_examinateur ? User::where('id', $jury_examinateur->user_id)->first()->nom ?? 'Inconnu' : 'Inconnu';
                    $soutenance['rapporteur_nom'] = $jury_rapporteur ? User::where('id', $jury_rapporteur->user_id)->first()->nom ?? 'Inconnu' : 'Inconnu';
                    
                    
                }
            }
            $enseignants = Professeurs::with('user')->get();
            $plannings = compact('soutenances','type');
            $horaire = Horaires::where('nom', 'like', 'L%')
            ->orderBy('debut')
            ->get()
            ->map(function ($horaire) {
                return [
                    'id' => $horaire->id,
                    'debut' => $horaire->debut,
                    'fin' => $horaire->fin
                ];
            })
            ->toArray();
            $salles = Salles:: all();
            $etudiants_nonProgrammes = Etudiants::when($type === 'Pre-Soutenance', function ($query) {
                return $query->where('is_ready', 2); // Si le type est "Presoutenance"
            })
            ->when($type === 'Soutenance', function ($query) {
                return $query->where('is_ready', 4); // Si le type est "Soutenance"
            })
            ->with('user')
            ->get();
            
    
            return view('planning\Modifierplanning', compact('soutenances','type','enseignants','plannings','selectedSessionId','horaire','salles','etudiants_nonProgrammes','days'));
 }

 public function afficherPlanning(Request $request)
 {
            // ID de la session
            
            $selectedSessionId = $request-> session_id;
            $type = $request-> type;
            
           
            $session = Sessions::findOrFail($selectedSessionId);

            // Déterminer les dates de début et de fin
            $startDate = null;
            $endDate = null;

            if ($type === 'Pre-Soutenance') {
                $startDate = Carbon::parse($session->session_start_PreSout);
                $endDate = Carbon::parse($session->session_end_PreSout);
            } elseif ($type === 'Soutenance') {
                $startDate = Carbon::parse($session->session_start_Sout);
                $endDate = Carbon::parse($session->session_end_Sout);
            } else {
                return redirect()->back()->with('error', 'Type de session invalide.');
            }

            // Générer les jours entre la date de début et la date de fin
            $days = [];
            while ($startDate->lte($endDate)) {
                $days[] = $startDate->toDateString();
                $startDate->addDay();
            }

          
            $soutenances = Soutenance::where('session_id', $selectedSessionId)
            ->where('type', $type)
            ->get()
            ->groupBy('jour'); // Regrouper par le champ "jour"
           
            $totalSoutenances = Soutenance::where('session_id', $selectedSessionId)
            ->where('type', $type)
            ->count();

            
            foreach ($soutenances as $jour => &$soutenances_jour){       
                foreach ($soutenances_jour as &$soutenance){
                    // Récupérer l'étudiant
                    
                    $student = Etudiants::find($soutenance['etudiant_id']);
                    $theme = $student->theme;
                    $etudiant = User::where('id', $student->user_id)->first();
                    $soutenance['etudiant_nom'] = $etudiant ? $etudiant->prenom . ' ' . $etudiant->nom : 'Inconnu';
                    $soutenance['theme'] =$theme ;
                    $salles = Salles::find($soutenance['salle_id']);
                    $soutenance['salle_nom'] = $salles ? $salles->nom : 'Inconnu';
                    $jury = Jury::find($soutenance['jury_id']);
                    // Récupérer les membres du jury dans la table Professeur
                    $jury_president = Professeurs::find($jury['president']);
                    $jury_examinateur = Professeurs::find($jury['examinateur']);
                    $jury_rapporteur = Professeurs::find($jury['rapporteur']);
                    $soutenance['niveau_etude'] = $student -> niveau_etude;
                    $horaire = Horaires ::find($soutenance['horaire_id']);
                    $soutenance['Plage Horaire'] = $horaire->debut . ' - ' . $horaire->fin;

                    $soutenance['president'] = $jury['president'];
                    $soutenance['examinateur'] = $jury['examinateur'];
                    $soutenance['rapporteur'] = $jury['rapporteur'];
                    $soutenance['president_nom'] = $jury_president ? User::where('id', $jury_president->user_id)->first()->nom ?? 'Inconnu' : 'Inconnu';
                    $soutenance['examinateur_nom'] =  $jury_examinateur ? User::where('id', $jury_examinateur->user_id)->first()->nom ?? 'Inconnu' : 'Inconnu';
                    $soutenance['rapporteur_nom'] = $jury_rapporteur ? User::where('id', $jury_rapporteur->user_id)->first()->nom ?? 'Inconnu' : 'Inconnu';
                    
                    
                }
            }
            $enseignants = Professeurs::with('user')->get();
            $plannings = compact('soutenances','type');
            $horaire = Horaires::where('nom', 'like', 'L%')
            ->orderBy('debut')
            ->get()
            ->map(function ($horaire) {
                return [
                    'id' => $horaire->id,
                    'debut' => $horaire->debut,
                    'fin' => $horaire->fin
                ];
            })
            ->toArray();
            $salles = Salles:: all();
       
            if ($type === 'Pre-Soutenance') {
                $problemes = Etudiants::where('is_ready', 2)->pluck('id');
            } elseif ($type === 'Soutenance') {
                $problemes = Etudiants::where('is_ready', 4)->pluck('id');
            } else {
                $problemes = collect(); // Initialiser une collection vide si $type ne correspond à aucun cas
            }
            
            
            $names = []; // Initialiser un tableau pour stocker les noms
                
                foreach ($problemes as $probleme) {
                    $student = Etudiants::find($probleme);
                    if ($student) { // Vérifiez si l'étudiant existe
                        $etudiant = User::where('id', $student->user_id)->first();
                        if ($etudiant) { // Vérifiez si l'utilisateur existe
                            $names[] = $etudiant->prenom . ' ' . $etudiant->nom; // Ajouter nom complet
                        }
                    }
                }
            

            
             // Initialiser un tableau pour stocker les noms
            $metrics = []; // Initialiser un tableau pour stocker les noms
            
    
            return view('planning.showplanning', compact('plannings', 'soutenances', 'metrics', 'type', 'names','selectedSessionId','totalSoutenances'));
 }
 public function updateSoutenance(Request $request)
                {
                    // Valider les données du formulaire
                    $validated = $request->validate([
                        'theme' => 'required|string',
                        'etudiant_nom' => 'required|string',
                        'jour' => 'required|date',
                        'plage_horaire' => 'required|uuid|exists:horaires,id',
                        'salle_id' => 'required|uuid|exists:salles,id',
                        'president' => 'required|uuid|exists:professeurs,id',
                        'examinateur' => 'required|uuid|exists:professeurs,id',
                        'rapporteur' => 'required|uuid|exists:professeurs,id',
                    ]);
                    
                    // Trouver la soutenance à mettre à jour
                    $id = $request['soutenance_id'];
                    $soutenance = Soutenance::findOrFail($id);

                    // Vérifier si le jury existe déjà
                    $jury = Jury::where('president', $validated['president'])
                        ->where('examinateur', $validated['examinateur'])
                        ->where('rapporteur', $validated['rapporteur'])
                        ->first();
                        

                    // Si le jury n'existe pas, créez un nouveau jury
                    if (!$jury) {
                        $jury = Jury::create([
                            'president' => $validated['president'],
                            'examinateur' => $validated['examinateur'],
                            'rapporteur' => $validated['rapporteur'],
                            
                        ]);
                        
                    }
                    

                    // Mettre à jour les informations de la soutenance
                    $soutenance->update([
                        'theme' => $validated['theme'],
                        'jour' => $validated['jour'],
                        'horaire_id' => $validated['plage_horaire'],
                        'salle_id' => $validated['salle_id'],
                        'jury_id' => $jury->id, // Associe l'ID du jury à la soutenance
                    ]);
                    

                    return view('planning.redirectToModifier', [
                        'session_id' => $request['session_id'],
                        'type' => $request['type'],
                    ]);
                }
    
    public function savePlanning(Request $request)
    {
        
        try {
            
            // Décoder les données JSON du champ `plannings`
                $decodedPlannings = json_decode($request->input('plannings'), true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return response()->json(['error' => 'Invalid JSON format in plannings'], 400);
                }

            // Ajouter les données décodées à la requête pour validation
            $request->merge(['plannings' => $decodedPlannings]);
            
                // Récupérer les données du planning validé par l'administrateur
            $validatedData = $request->validate([
                'plannings' => 'required|array',
                'plannings.soutenances' => 'required|array',
                'plannings.type' => 'required|string',
                'session_id' => 'required|string',
            ], [
                'plannings.required' => 'Les plannings sont requis.',
                'plannings.array' => 'Le format des plannings est incorrect.',
                'plannings.soutenances.required' => 'Les soutenances sont manquantes.',
                'plannings.type.required' => 'Le type de planning est requis.',
            ]);
            
            

            $plannings = $validatedData['plannings'];
            $type = $plannings['type'];
            $session_id = $validatedData['session_id'];
           
         

                // Sauvegarder les données dans la DB si nécessaire
                foreach ($plannings['soutenances'] as $jour => $soutenances) 
                {
                    foreach ($soutenances as $soutenance) {
                        // Extraire les horaires (début et fin) de la plage horaire
                        $plageHoraire = explode(' - ', $soutenance['Plage Horaire']); // Exemple : "08:00 - 09:30"
                        $debut = $plageHoraire[0] ?? null; 
                        $fin = $plageHoraire[1] ?? null;   

                        // Trouver l'horaire correspondant dans la table Horaires
                        $horaire = Horaires::where('debut', $debut)
                            ->where('fin', $fin)
                            ->first();

                            if ($horaire) {
                                // Vérifier si le jury existe déjà avec le même président, examinateur et rapporteur
                                $jury = Jury::where('president', $soutenance['president'])
                                ->where('examinateur', $soutenance['examinateur'])
                                ->where('rapporteur', $soutenance['rapporteur'])
                                ->first(); // Récupère le premier résultat ou null si rien n'est trouvé

                                if (!$jury) {
                                // Si le jury n'existe pas, créez un nouveau jury
                                $jury = Jury::create([
                                'president' => $soutenance['president'],
                                'examinateur' => $soutenance['examinateur'],
                                'rapporteur' => $soutenance['rapporteur'],
                                ]);
                                }
                    
                                // Sauvegarder la soutenance avec l'ID de l'horaire trouvé
                                $soutenanceExistante = Soutenance::where('etudiant_id', $soutenance['etudiant_id'])
                                    ->where('type', $type)
                                    ->where('session_id', $session_id)
                                    ->first();

                                if (!$soutenanceExistante) {
                                    Soutenance::create([
                                        'jour' => $soutenance['jour'],
                                        'horaire_id' => $horaire->id,
                                        'jury_id' => $jury->id,
                                        'etudiant_id' => $soutenance['etudiant_id'],
                                        'salle_id' => $soutenance['salle_id'],
                                        'type' => $type,
                                        'session_id' => $session_id,
                                    ]);
                                }

                                
                                // Trouver l'étudiant
                                $etudiant = Etudiants::findOrFail($soutenance['etudiant_id']);
                                

                                // Mettre à jour la valeur de 'is_ready'
                                $etudiant->is_ready = ($type == 'Pre-Soutenance') ? 3 : 5; // l'etudiant est programmé pour la 
                                $etudiant->save();

                                $horaireId = $horaire->id;
                               // Supprimer les disponibilités du jury et de la salle pour cette plage horaire
                               
                                // Supprimer la disponibilité du président
                                $deletedPresident = AvailabilityTeachers::where('horaire_id', $horaireId)
                                ->where('jour', $soutenance['jour'])
                                ->where('prof_id', $soutenance['president'])
                                ->delete();
                                

                                // Supprimer la disponibilité de l'examinateur
                                $deletedExaminateur = AvailabilityTeachers::where('horaire_id', $horaireId)
                                ->where('jour', $soutenance['jour'])
                                ->where('prof_id', $soutenance['examinateur'])
                                ->delete();
                                
                                

                                // Supprimer la disponibilité du rapporteur
                                $deletedRapporteur = AvailabilityTeachers::where('horaire_id', $horaireId)
                                ->where('jour', $soutenance['jour'])
                                ->where('prof_id', $soutenance['rapporteur'])
                                ->delete();
                                

                                // Supprimer la disponibilité de la salle
                               $deletedSalle = AvailabilityRooms::where('horaire_id', $horaireId)
                                ->where('salle_id', $soutenance['salle_id'])
                                ->where('jour', $soutenance['jour'])
                                ->delete();
/* 
                                // Vérification des suppressions
                                if ($deletedPresident > 0) {
                                echo "La disponibilité du président a été supprimée ($deletedPresident ligne(s)).\n";
                                } else {
                                echo "Aucune disponibilité du président n'a été supprimée.\n";
                                }

                                if ($deletedExaminateur > 0) {
                                echo "La disponibilité de l'examinateur a été supprimée ($deletedExaminateur ligne(s)).\n";
                                } else {
                                echo "Aucune disponibilité de l'examinateur n'a été supprimée.\n";
                                }

                                if ($deletedRapporteur > 0) {
                                echo "La disponibilité du rapporteur a été supprimée ($deletedRapporteur ligne(s)).\n";
                                } else {
                                echo "Aucune disponibilité du rapporteur n'a été supprimée.\n";
                                }

                                if ($deletedSalle > 0) {
                                echo "La disponibilité de la salle a été supprimée ($deletedSalle ligne(s)).\n";
                                } else {
                                echo "Aucune disponibilité de la salle n'a été supprimée.\n";
                                }
                               */

                            }
                            else {
                            // Gérer le cas où l'horaire n'est pas trouvé
                            throw new \Exception("Horaire non trouvé pour la plage : " . $soutenance['Plage Horaire']);
                        }
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Planning sauvegardé avec succès.',
                ]);
            
           
        } catch (\Exception $e) {
            // Gérer les erreurs côté Laravel
            return response()->json([
                'success' => false,
                'message' => 'Une erreur inattendue est survenue lors de la sauvegarde.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkJuryAvailability(Request $request)
    {
        $validated = $request->validate([
            'president' => 'required|uuid|exists:professeurs,id',
            'examinateur' => 'required|uuid|exists:professeurs,id',
            'rapporteur' => 'required|uuid|exists:professeurs,id',
            'jour' => 'required|date',
            'horaire_id' => 'required|uuid|exists:horaires,id',
        ]);
    
        $jury = [
            'president' => $validated['president'],
            'examinateur' => $validated['examinateur'],
            'rapporteur' => $validated['rapporteur'],
        ];
    
        $missingAvailability = [];
    
        foreach ($jury as $role => $profId) {
            $availability = AvailabilityTeachers::where('prof_id', $profId)
                ->where('jour', $validated['jour'])
                ->where('horaire_id', $validated['horaire_id'])
                ->first();
    
            if (!$availability) {
                $missingAvailability[] = $role;
            }
        }
    
        // Si des disponibilités manquent, demander confirmation
        if (!empty($missingAvailability)) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Les disponibilités des membres suivants sont manquantes : ' . implode(', ', $missingAvailability),
                'confirm' => true,
            ]);
        }
    
        // Toutes les disponibilités sont présentes
        return response()->json([
            'status' => 'success',
            'message' => 'Tous les membres du jury sont disponibles.',
        ]);
    }

    public function storeSoutenance(Request $request)
    {   
        
        $selectedSessionId = $request-> session_id;
        $type = $request-> type;
        
        // Validation des données
        $validated = $request->validate([
            'president' => 'required|uuid|exists:professeurs,id',
            'examinateur' => 'required|uuid|exists:professeurs,id',
            'rapporteur' => 'required|uuid|exists:professeurs,id',
            'session_id' => 'required|uuid|exists:sessions,id',
            'jour' => 'required|date',
            'horaire_id' => 'required|uuid|exists:horaires,id',
            'etudiant_id' => 'required|uuid|exists:etudiants,id',
            'salle_id' => 'required|uuid|exists:salles,id',
            'type' => 'required|string|in:Pre-Soutenance,Soutenance',
        ]);
    
        // Vérifier si le jury existe déjà
        $jury = Jury::where('president', $validated['president'])
            ->where('examinateur', $validated['examinateur'])
            ->where('rapporteur', $validated['rapporteur'])
            ->first();
    
        if (!$jury) {
            // Si le jury n'existe pas, créez un nouveau jury
            $jury = Jury::create([
                'president' => $validated['president'],
                'examinateur' => $validated['examinateur'],
                'rapporteur' => $validated['rapporteur'],
            ]);
        }
    
        // Créer la soutenance
        $soutenance = Soutenance::firstOrCreate([
            'jour' => $validated['jour'],
            'horaire_id' => $validated['horaire_id'],
            'jury_id' => $jury->id,
            'etudiant_id' => $validated['etudiant_id'],
            'salle_id' => $validated['salle_id'],
            'type' => $validated['type'],
            'session_id' => $validated['session_id'],
        ]);
        
        
        // Mettre à jour le statut de l'étudiant
        $etudiant = Etudiants::findOrFail($validated['etudiant_id']);
        $etudiant->is_ready = ($validated['type'] === 'Pre-Soutenance') ? 3 : 5;
        $etudiant->save();
    
        // Supprimer les disponibilités du jury et de la salle pour cette plage horaire
        AvailabilityTeachers::where('horaire_id', $validated['horaire_id'])
        ->where('jour', $validated['jour'])
        ->where('prof_id', $validated['president'])
        ->delete();
        AvailabilityTeachers::where('horaire_id', $validated['horaire_id'])
            ->where('jour', $validated['jour'])
            ->where('prof_id', $validated['examinateur'])
            ->delete();
        AvailabilityTeachers::where('horaire_id', $validated['horaire_id'])
            ->where('jour', $validated['jour'])
            ->where('prof_id', $validated['rapporteur'])
            ->delete();
    
        AvailabilityRooms::where('horaire_id', $validated['horaire_id'])
            ->where('salle_id', $validated['salle_id'])
            ->where('jour', $validated['jour'])
            ->delete();
    
            return view('planning.redirectToModifier', [
                'session_id' => $selectedSessionId,
                'type' => $type,
            ]);
            
    }
    
    public function redirectToModifierPlanning(Request $request)
{
    $selectedSessionId = $request->session_id;
    $type = $request->type;

    return view('AdminPages.ModifierPlanningRedirect', [
        'url' => route('ModifierPlanning'),
        'session_id' => $selectedSessionId,
        'type' => $type,
    ]);
}

    
public function envoyerPlanning(Request $request)
{
    try {
        // Validation des données reçues
        $request->validate([
            'session_id' => 'required|uuid',
            'type' => 'required|string',
        ]);

        $session_id = $request->input('session_id');
        $type = $request->input('type');

        // Récupérer toutes les soutenances pour la session donnée
        $soutenances = Soutenance::with([
            'etudiant.user',
            'jury.presidents.user',
            'jury.examinateurs.user',
            'jury.rapporteurs.user'
        ])->where('session_id', $session_id)->where('type',  $type)->get();

        // Structure pour stocker les soutenances par professeur
        $planningsParProfesseur = [];

        // Parcourir chaque soutenance pour organiser les données
        foreach ($soutenances as $soutenance) {
            // Préparer les données du planning
            $planning = [
                'jour' => $soutenance->jour,
                'horaire' => $soutenance->horaire ? $soutenance->horaire->debut . ' - ' . $soutenance->horaire->fin : null,
                'salle' => $soutenance->salle ? $soutenance->salle->nom : null,
                'type' => $soutenance->type,
                'etudiant' => $soutenance->etudiant ? $soutenance->etudiant->user->nom . ' ' . $soutenance->etudiant->user->prenom : 'Inconnu',
                'jury' => [
                        'president' => $soutenance->jury->presidents,
                        'examinateur' => $soutenance->jury->examinateurs,
                        'rapporteur' => $soutenance->jury->rapporteurs,
                    ],
            ];

            // Envoi du planning à l'étudiant
            if ($soutenance->etudiant && $soutenance->etudiant->user) {
                $etudiant = $soutenance->etudiant->user;

                $etudiant->notify(new PlanningNotification($planning, $type));
            }

            $professeurs = [
                $soutenance->jury->presidents,
                $soutenance->jury->examinateurs,
                $soutenance->jury->rapporteurs
            ];
        
            foreach ($professeurs as $professeur) {
                if ($professeur && $professeur->user) {
                    // Ajouter le planning pour ce professeur
                    $userId = $professeur->user->id;
        
                    // Initialiser l'entrée pour ce professeur si nécessaire
                    if (!isset($planningsParProfesseur[$userId])) {
                        $planningsParProfesseur[$userId] = [
                            'professeur' => $professeur->user,
                            'plannings' => [],
                        ];
                    }
        
                    // Ajouter le planning à la liste des soutenances du professeur
                    $planningsParProfesseur[$userId]['plannings'][] = $planning;
                }
            }
        }
       

        // Générer et envoyer les PDF pour chaque professeur
        foreach ($planningsParProfesseur as $data) {
            $professeur = $data['professeur'];
            $plannings = $data['plannings'];

            // Envoyer le PDF au professeur
            //$professeur->notify(new PlanningNotification($plannings, $type));
        }

        return response()->json(['message' => 'Planning envoyé avec succès.'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erreur lors de l\'envoi du planning.', 'error' => $e->getMessage()], 500);
    }
}


}