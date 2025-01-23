<?php

namespace App\Http\Controllers;

use App\Models\Horaires;
use App\Models\Sessions;
use App\Models\Salles;
use App\Models\Grades;
use App\Models\Professeurs;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Speciality;
use App\Models\Soutenance;
use App\Models\Etudiants;
use App\Models\User;



class GeneralesController extends Controller
{
    public function ShowInfos($session_id)
    {
        $latestHoraire = Horaires::latest('nom')->first();
    
        if ($latestHoraire === null) {
            $newName = 'L11';
        } else {
            $latestNameNumber = intval(substr($latestHoraire->nom, 1));
            $newName = 'L' . ($latestNameNumber + 1);
        }

        $horaires = Horaires::orderBy('nom', 'asc')->get();
        $salles = Salles::all('*');
        $grades = Grades::all('*');
        $sessions = Sessions::where('id',$session_id)->get();
        $specialites = Speciality::orderBy('name', 'asc')->get();
        $professeurs = Professeurs::with('user')->get();
    
        return view('AdminPages.Settings', compact('horaires','salles','grades','sessions','newName','specialites','professeurs'));
    }

    public function storeSpeciality(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Convertir le champ en majuscules avant de l'enregistrer
        Speciality::create([
            'name' => strtoupper($request->name),
        ]);

        return redirect()->back()->with('success', 'Spécialité ajoutée avec succès.');
    }

    public function updateSpeciality(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:specialities,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('specialities', 'name')->ignore($request->id),
            ],
        ], [
            'name.unique' => 'Le nom de spécialité existe déjà.',
        ]);
        
        
        // Récupération de la spécialité à mettre à jour
        $specialite = Speciality::findOrFail($request->id);

        // Mise à jour du nom de la spécialité
        $specialite->update(['name' => $request->name]);


         // Récupération des professeurs sélectionnés dans le formulaire
            $selectedProfesseurs = $request->professeurs ?? []; // IDs des professeurs sélectionnés
            $allProfesseurs = Professeurs::all(); // Tous les professeurs

            foreach ($allProfesseurs as $professeur) {
               
                $specialities = is_string($professeur->specialities_ids) ? json_decode($professeur->specialities_ids, true): $professeur->specialities_ids;

                if (in_array($professeur->id, $selectedProfesseurs)) {
                    // Ajouter la spécialité si elle n'est pas déjà présente
                    if (!in_array($specialite->id, $specialities)) {
                        $specialities[] = $specialite->id;
                    }
                } else {
                    // Supprimer la spécialité si elle est présente
                    if (($key = array_search($specialite->id, $specialities)) !== false) {
                        unset($specialities[$key]);
                    }
                }

                // Mettre à jour les spécialités du professeur
                $professeur->specialities_ids = json_encode(array_values($specialities));
                $professeur->save();
            }

        return redirect()->back()->with('success', 'Spécialité modifiée avec succès.');
    }

    public function destroySpeciality(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:specialities,id',
        ]);

        $specialite = Speciality::find($request->id);
        $specialite->delete();

        return redirect()->back()->with('success', 'Spécialité supprimée avec succès.');
    }



    public function AddSessions(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:sessions',
            'session_start_PreSout' => 'required|date',
            'session_end_PreSout' => 'required|date|after_or_equal:session_start_PreSout',
            'session_start_Sout' => 'required|date',
            'session_end_Sout' => 'required|date|after_or_equal:session_start_Sout',
            'nb_soutenance_max_prof' => 'required|integer|min:1', // Au moins 1 soutenance
            'grademin_licence' => 'required|integer|min:0', // Grade minimum >= 0
            'grademin_master' => 'required|integer|min:0',  // Grade minimum >= 0
        ], [
            'nom.required' => 'Le champ nom est requis.',
            'nom.unique' => 'Le nom de session existe déjà.',
            'session_start_PreSout.required' => 'La date de début de la présoutenance est requise.',
            'session_end_PreSout.required' => 'La date de fin de la présoutenance est requise.',
            'session_end_PreSout.after_or_equal' => 'La date de fin de la présoutenance doit être postérieure ou égale à la date de début.',
            'session_start_Sout.required' => 'La date de début de la soutenance est requise.',
            'session_end_Sout.required' => 'La date de fin de la soutenance est requise.',
            'session_end_Sout.after_or_equal' => 'La date de fin de la soutenance doit être postérieure ou égale à la date de début.',
            'nb_soutenance_max_prof.required' => 'Le nombre maximal de soutenances par professeur est requis.',
            'nb_soutenance_max_prof.integer' => 'Le nombre maximal de soutenances doit être un entier.',
            'grademin_licence.required' => 'Le grade min pour la licence est requis.',
            'grademin_master.required' => 'Le grade min pour le master est requis.',
            'grademin_licence.integer' => 'Le grade min pour la licence doit être un entier.',
            'grademin_master.integer' => 'Le grade min pour le master doit être un entier.',
        ]);
    
        // Vérification si les grades existent dans la base de données
        $grademinLicenceId = $request->input('grademin_licence');
        $grademinMasterId = $request->input('grademin_master');
    
        $gradeLicenceExists = Grades::where('id', $grademinLicenceId)->exists();
        $gradeMasterExists = Grades::where('id', $grademinMasterId)->exists();
    
        if (!$gradeLicenceExists) {
            return redirect()->back()->withErrors(['grademin_licence' => 'Le grade pour la licence n\'est pas pris en charge.']);
        }
    
        if (!$gradeMasterExists) {
            return redirect()->back()->withErrors(['grademin_master' => 'Le grade pour le master n\'est pas pris en charge.']);
        }
    
        // Création de la session
        $session = new Sessions([
            'nom' => $request->input('nom'),
            'session_start_PreSout' => $request->input('session_start_PreSout'),
            'session_end_PreSout' => $request->input('session_end_PreSout'),
            'session_start_Sout' => $request->input('session_start_Sout'),
            'session_end_Sout' => $request->input('session_end_Sout'),
            'nb_soutenance_max_prof' => $request->input('nb_soutenance_max_prof'),
            'grademin_licence' => $grademinLicenceId, // ID validé
            'grademin_master' => $grademinMasterId,  // ID validé
        ]);
    
        $session->save();
    
        return redirect()->back()->with('success', 'Session enregistrée.');
    }

    public function destroy($session_id)
    {
        try {
           
            
            // Trouver la session ou renvoyer une erreur 404
            $session = Sessions::findOrFail($session_id);
            //dd('Session trouvée : ' . $session->nom);
    
            // Récupérer toutes les soutenances associées
            $soutenances = Soutenance::where('session_id', $session_id)->get();
            //dd('Soutenances trouvées : ' . $soutenances->count());
            foreach ($soutenances as $soutenance) {
                $etudiant = Etudiants::find($soutenance->etudiant_id);
    
                if ($etudiant) {
                    // Supprimer l'utilisateur associé à l'étudiant
                    //User::where('id', $etudiant->user_id)->delete();
                    
                    $etudiant->soutenances()->delete();
                    // Supprimer l'étudiant
                   
                    $etudiant->delete();
                    
                }
    
                // Supprimer la soutenance
                
                
            }

            $session->soutenances()->delete() ;
            $session -> rooms()->delete () ;
            $session -> teachers()->delete() ;
            // Supprimer la session
            $session->delete();
            
    
            return redirect()->route('choiceSession')->with('success', 'Session supprimée avec succès.');
        } catch (\Exception $e) {
            // En cas d'erreur, enregistrer le message pour débogage si nécessaire
            \Log::error('Erreur lors de la suppression de la session : ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression de la session.');
        }
    }
    

    
    public function AddSalles(Request $request)
    {
        $request->validate([
            'nom' => 'required|unique:salles',
        ], [
            'nom.required' => 'Le champ nom est requis.',
            'nom.unique' => 'Le nom existe déjà.',
        ]);

        $salle = new Salles([
            'nom' => $request->input('nom'),
            'description' => $request->input('description'),
            'localisation' => $request->input('localisation'),
        ]);

        $salle->save();

        return redirect()->back()->with('success', 'Salle enregistrée.');
    }
    public function AddHoraires(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'regex:/^[LM]/'], // Doit commencer par L ou M
            'debut' => 'required|unique:horaires',
            'fin' => 'required|unique:horaires',
        ], [
            'nom.required' => 'Le champ nom est requis.',
            'nom.regex' => 'Le nom doit commencer par "L" ou "M".',
            'debut.unique' => 'L\'heure de début existe déjà.',
            'fin.unique' => 'L\'heure de fin existe déjà.',
            'debut.required' => 'Le champ heure de début est requis.',
            'fin.required' => 'Le champ heure de fin est requis.',
        ]);
    
        $horaire = new Horaires([
            'nom' => $request->input('nom'),
            'debut' => $request->input('debut'),
            'fin' => $request->input('fin'),
        ]);
    
        $horaire->save();
    
        return redirect()->back()->with('success', 'Horaire enregistré.');
    }
    
    public function UpdateSalles(Request $request)
    {
        $salleId = $request->id;

        $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('salles')->ignore($salleId),
            ],
            'description' => 'nullable|string|max:255',
            'localisation' => 'nullable|string|max:255',
        ], [
            'nom.required' => 'Le nom est obligatoire',
            'nom.unique' => 'Le nom de la salle existe déjà',
        ]);

        $salle = Salles::findOrFail($salleId);
        $salle->nom = $request->input('nom');
        $salle->description = $request->input('description');
        $salle->localisation = $request->input('localisation');
        $salle->save();

        return redirect()->back()->with('success', 'Salle mise à jour avec succès.');
    }

    public function UpdateSession(Request $request)
    {
        $sessionId = $request->id;
    
        // Validation initiale des données
        $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sessions')->ignore($sessionId),
            ],
            'session_start_PreSout' => 'required|date',
            'session_end_PreSout' => 'required|date|after_or_equal:session_start_PreSout',
            'session_start_Sout' => 'required|date',
            'session_end_Sout' => 'required|date|after_or_equal:session_start_Sout',
            'nb_soutenance_max_prof' => 'required|integer|min:1',
            'grademin_licence' => 'required|integer|min:0',
            'grademin_master' => 'required|integer|min:0',
        ], [
            'nom.required' => 'Le champ nom est requis.',
            'nom.unique' => 'Le nom de session existe déjà.',
            'session_start_PreSout.required' => 'La date de début de la présoutenance est requise.',
            'session_end_PreSout.required' => 'La date de fin de la présoutenance est requise.',
            'session_end_PreSout.after_or_equal' => 'La date de fin de la présoutenance doit être postérieure ou égale à la date de début.',
            'session_start_Sout.required' => 'La date de début de la soutenance est requise.',
            'session_end_Sout.required' => 'La date de fin de la soutenance est requise.',
            'session_end_Sout.after_or_equal' => 'La date de fin de la soutenance doit être postérieure ou égale à la date de début.',
            'nb_soutenance_max_prof.required' => 'Le nombre maximal de soutenances par professeur est requis.',
            'nb_soutenance_max_prof.integer' => 'Le nombre maximal de soutenances doit être un entier.',
            'grademin_licence.required' => 'Le grade min pour la licence est requis.',
            'grademin_master.required' => 'Le grade min pour le master est requis.',
            'grademin_licence.integer' => 'Le grade min pour la licence doit être un entier.',
            'grademin_master.integer' => 'Le grade min pour le master doit être un entier.',
        ]);
    
        // Vérification si les grades existent dans la base de données
        $grademinLicenceId = $request->input('grademin_licence');
        $grademinMasterId = $request->input('grademin_master');
    
        $gradeLicenceExists = Grades::where('id', $grademinLicenceId)->exists();
        $gradeMasterExists = Grades::where('id', $grademinMasterId)->exists();
    
        if (!$gradeLicenceExists) {
            return redirect()->back()->withErrors(['grademin_licence' => 'Le grade pour la licence n\'est pas pris en charge.']);
        }
    
        if (!$gradeMasterExists) {
            return redirect()->back()->withErrors(['grademin_master' => 'Le grade pour le master n\'est pas pris en charge.']);
        }
    
        // Récupération de la session et mise à jour
        $session = Sessions::findOrFail($sessionId);
    
        $session->nom = $request->input('nom');
        $session->session_start_PreSout = $request->input('session_start_PreSout');
        $session->session_end_PreSout = $request->input('session_end_PreSout');
        $session->session_start_Sout = $request->input('session_start_Sout');
        $session->session_end_Sout = $request->input('session_end_Sout');
        $session->nb_soutenance_max_prof = $request->input('nb_soutenance_max_prof');
        $session->grademin_licence = $grademinLicenceId; // Utilisation de l'ID validé
        $session->grademin_master = $grademinMasterId;  // Utilisation de l'ID validé
    
        $session->save();
    
        return redirect()->back()->with('success', 'Session mise à jour avec succès.');
    }    
    
}
