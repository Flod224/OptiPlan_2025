<?php

namespace App\Http\Controllers;

use App\Models\AvailabilityRooms;
use App\Models\Professeurs;
use App\Models\Sessions;
use App\Models\AvailabilityTeachers;
use App\Models\Salles;
use App\Models\Horaires;
use App\Notifications\TeachersDispoMail;
use Illuminate\Http\Request;

// à revisiter
class DisponibilitesController extends Controller
{
    /*Disponibilite DES PROFS*/
    public function Disponibilite($session_id)
    {
        // Récupérer l'ID du professeur connecté
        $professeurId = auth()->user()->id;

        // Récupérer uniquement les données du professeur connecté
        $professeur = Professeurs::find($professeurId);

        $session = Sessions::where('id', $session_id)->first(); // Une seule session
        $disponibilites = AvailabilityTeachers::where('session_id',$session_id)->get();
    
        return view('AdminPages.DisponibiliteEnseignant', compact('professeurs','sessions','disponibilites'));
    }
    public function AddDisponibiliteProfesseur(Request $request)
{
    // Récupération de la session
    $session = Sessions::find($request->input('session_id'));

    if (!$session) {
        return redirect()->back()->with('error', 'Session invalide ou introuvable.');
    }

    // Validation des données
    $request->validate([
        'jour' => [
            'required',
            'date',
            function ($attribute, $value, $fail) use ($request, $session) {
                $typeSoutenance = $request->input('type_soutenance');

                if ($typeSoutenance === 'Pre-Soutenance' && ($value < $session->session_start_PreSout || $value > $session->session_end_PreSout)) {
                    $fail("La date doit être comprise entre {$session->session_start_PreSout} et {$session->session_end_PreSout} pour une Pré-Soutenance.");
                }

                if ($typeSoutenance === 'Soutenance' && ($value < $session->session_start_Sout || $value > $session->session_end_Sout)) {
                    $fail("La date doit être comprise entre {$session->session_start_Sout} et {$session->session_end_Sout} pour une Soutenance.");
                }
            },
        ],
        'session_id' => 'required|exists:sessions,id',
        'type_soutenance' => 'required|in:Pre-Soutenance,Soutenance',
        'horaire_id' => 'nullable|required_unless:all_day,true|array|exists:horaires,id',
        'all_day' => 'sometimes|boolean',
    ], [
        'jour.required' => 'La date est obligatoire.',
        'jour.date' => 'La date fournie est invalide.',
        'session_id.required' => 'La session est obligatoire.',
        'session_id.exists' => 'La session sélectionnée n\'existe pas.',
        'type_soutenance.required' => 'Le type de soutenance est obligatoire.',
        'type_soutenance.in' => 'Le type de soutenance doit être "Pré-Soutenance" ou "Soutenance".',
        'horaire_id.required_unless' => 'Veuillez sélectionner un horaire ou activer l\'option "Toute la journée".',
        'horaire_id.exists' => 'Un ou plusieurs horaires sélectionnés n\'existent pas.',
        'all_day.boolean' => 'Le champ "Toute la journée" doit être un booléen.',
    ]);

    // Récupération des données du formulaire
    $jour = $request->input('jour');
    $sessionId = $request->input('session_id');
    $typeSoutenance = $request->input('type_soutenance');
    $allDay = $request->boolean('all_day');
    $horaireIds = $request->input('horaire_id', []);
    $professeur = auth()->user()->professeur;

    if (!$professeur) {
        return redirect()->back()->with('error', 'Aucun professeur associé à cet utilisateur.');
    }

    // Gestion des disponibilités
    if ($allDay) {
        // Si toute la journée est activée, récupérer tous les horaires disponibles
        $horaires = Horaires::where('nom', 'LIKE', 'L%')->orderBy('debut')->get();

        if ($horaires->isEmpty()) {
            return redirect()->back()->with('error', 'Aucune plage horaire disponible.');
        }

        foreach ($horaires as $horaire) {
            $this->createAvailabilityProf($professeur->id, $jour, $horaire->id, $sessionId, $typeSoutenance);
        }
    } else {
        // Ajouter une disponibilité pour chaque horaire sélectionné
        if (empty($horaireIds)) {
            return redirect()->back()->with('error', 'Veuillez sélectionner au moins un horaire.');
        }

        foreach ($horaireIds as $horaireId) {
            $this->createAvailabilityProf($professeur->id, $jour, $horaireId, $sessionId, $typeSoutenance);
        }
    }

    return redirect()->back()->with('success', 'Disponibilités enregistrées avec succès.');
}

/**
 * Créer une disponibilité pour un professeur
 *
 * @param int $professeurId
 * @param string $jour
 * @param int $horaireId
 * @param int $sessionId
 * @param string $typeSoutenance
 * @return void
 */
private function createAvailabilityProf($professeurId, $jour, $horaireId, $sessionId, $typeSoutenance)
{
    $existingAvailability = AvailabilityTeachers::where([
        'prof_id' => $professeurId,
        'jour' => $jour,
        'horaire_id' => $horaireId,
        'session_id' => $sessionId,
        'type_soutenance' => $typeSoutenance,
    ])->exists();

    if (!$existingAvailability) {
        AvailabilityTeachers::create([
            'prof_id' => $professeurId,
            'jour' => $jour,
            'horaire_id' => $horaireId,
            'session_id' => $sessionId,
            'type_soutenance' => $typeSoutenance,
        ]);
    }
}


    public function DeleteDispo(Request $request, $id){
        try {
            $dispo = AvailabilityTeachers::findOrFail($id);
            $dispo->delete();

            return response()->json(['message' => 'Suppression effectuée'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Une erreur est survenue lors de la suppression'], 500);
        }
    }



                /*Disponibilite DES SALLES*/


    public function DisponibiliteSalle($session_id)
{
    $horaire = Horaires::where('nom', 'LIKE', 'L%')->orderBy('debut')->get();
    $salles = Salles::all('*');
    $session = Sessions::where('id', $session_id)->first(); // Une seule session
    $disponibilites = AvailabilityRooms::with('salle', 'horaires') // Chargement des relations utiles
        ->where('session_id', $session_id)
        ->get();

    return view('AdminPages.DisponibiliteSalle', compact('salles', 'session', 'disponibilites', 'horaire'));
}

public function AddDisponibiliteSalle(Request $request)
{
     // Récupérer les données de la requête
     $sessionId = $request->input('session_id');
     $session = Sessions::find($sessionId); // Récupérer la session correspondante
    // Validation des données
    $request->validate([
        'salle_id' => 'required|array',  // Vérifier que salle_id est un tableau
        'salle_id.*' => 'exists:salles,id', // Vérifier que chaque ID de salle existe dans la base
        'jour' => [
            'required',
            'date',
            function ($attribute, $value, $fail) use ($request, $session) {
                $typeSoutenance = $request->input('type_soutenance');
                if ($typeSoutenance === 'Pre-Soutenance') {
                    if ($value < $session->session_start_PreSout || $value > $session->session_end_PreSout) {
                        $fail("La date doit être comprise entre {$session->session_start_PreSout} et {$session->session_end_PreSout} pour une Pre-Soutenance.");
                    }
                } elseif ($typeSoutenance === 'Soutenance') {
                    if ($value < $session->session_start_Sout || $value > $session->session_end_Sout) {
                        $fail("La date doit être comprise entre {$session->session_start_Sout} et {$session->session_end_Sout} pour une Soutenance.");
                    }
                }
            },
        ],
        'session_id' => 'required|exists:sessions,id',
        'type_soutenance' => 'required|in:Pre-Soutenance,Soutenance',
        'horaire_id' => 'nullable|required_unless:all_day,true|exists:horaires,id|array',
        'all_day' => 'sometimes|boolean',
    ], [
        'salle_id.required' => 'Veuillez sélectionner au moins une salle.',
        'salle_id.*.exists' => 'Une ou plusieurs salles sélectionnées n\'existent pas.',
        'jour.required' => 'La date est obligatoire.',
        'jour.date' => 'La date fournie est invalide.',
        'session_id.required' => 'La session est obligatoire.',
        'session_id.exists' => 'La session sélectionnée n\'existe pas.',
        'type_soutenance.required' => 'Le type de soutenance est obligatoire.',
        'type_soutenance.in' => 'Le type de soutenance doit être "Pre-Soutenance" ou "Soutenance".',
        'horaire_id.required_unless' => 'Veuillez sélectionner un horaire ou activer l\'option "Toute la journée".',
        'horaire_id.exists' => 'L\'horaire sélectionné n\'existe pas.',
        'all_day.boolean' => 'Le champ "Toute la journée" doit être un booléen.',
    ]);

    // Récupérer les salles sélectionnées
    $salleIds = $request->input('salle_id');
    $jour = $request->input('jour');
    $sessionId = $request->input('session_id');
    $typeSoutenance = $request->input('type_soutenance');
    $allDay = $request->input('all_day', false);
    $horaireId = (array) $request->input('horaire_id'); // S'assurer que horaire_id est toujours un tableau

    // Si l'option "Toute la journée" est activée
    if ($allDay) {
        $horaires = Horaires::where('nom', 'LIKE', 'L%')->orderBy('id')->get();
        if ($horaires->isEmpty()) {
            return redirect()->back()->with('error', 'Aucune plage horaire disponible.');
        }

        // Boucler sur chaque salle sélectionnée
        foreach ($salleIds as $salleId) {
            foreach ($horaires as $horaire) {
                $this->createAvailability($salleId, $jour, $horaire->id, $sessionId, $typeSoutenance);
            }
        }
    } else {
        // Ajouter une disponibilité pour chaque salle sélectionnée avec un horaire spécifique
        if (!empty($horaireId)) {
            foreach ($salleIds as $salleId) {
                foreach ($horaireId as $horaire) {
                    $this->createAvailability($salleId, $jour, $horaire, $sessionId, $typeSoutenance);
                }
            }
        } else {
            return redirect()->back()->with('error', 'Veuillez sélectionner un horaire ou activer l\'option "Toute la journée".');
        }
    }

    return redirect()->back()->with('success', 'Disponibilités enregistrées avec succès.');
}


private function createAvailability($salleId, $jour, $horaireId, $sessionId, $typeSoutenance)
    {
        $existing = AvailabilityRooms::where([
            'salle_id' => $salleId,
            'jour' => $jour,
            'horaire_id' => $horaireId,
            'session_id' => $sessionId,
            'type_soutenance' => $typeSoutenance,
        ])->first();

        if (!$existing) {
            AvailabilityRooms::create([
                'salle_id' => $salleId,
                'jour' => $jour,
                'horaire_id' => $horaireId,
                'session_id' => $sessionId,
                'type_soutenance' => $typeSoutenance,
            ]);
        }
    }


public function DeleteDispoSalle(Request $request, $id)
{
    try {
        $dispo = AvailabilityRooms::findOrFail($id);
        $dispo->delete();

        return response()->json(['message' => 'Disponibilité supprimée avec succès'], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Erreur lors de la suppression : ' . $e->getMessage(),
        ], 500);
    }
}


    public function dispoSallesEmpty()
    {
        AvailabilityRooms::truncate();

        return response()->json(['message' => 'Toutes les disponibilités ont été supprimées.']);
    }



    public function dispoProfsEmpty()
    {
        AvailabilityTeachers::truncate();

        return response()->json(['message' => 'Success.']);
    }

    /*
    public function dispoMailProf(Request $request)
    {
        $emails = $request->input('emails');
        $nameSession = $request->input('nameSession');
        $typeSout = $request->input('typeSout');
        $jours = $request->input('jours');

        foreach ($emails as $email) {
            $professeur = Professeurs::where('email', $email)->first();
            if ($professeur) {
                $mailProfDispo = new TeachersDispoMail($professeur->nom, $professeur->prenom, $nameSession, $typeSout, $jours);
                try {
                    $professeur->notify($mailProfDispo);

                } catch (\Exception $e) {
                    return response()->json(['error' => 'Une erreur est survenue. Vérifiez votre connexion internet.'], 500);
                }
            }
        }
    }*/
    

}
