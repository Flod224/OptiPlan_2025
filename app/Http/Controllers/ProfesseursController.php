<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Grades;
use App\Models\Sessions;
use App\Models\Professeurs;
use App\Models\User;
use App\Models\Speciality;
use Illuminate\Support\Facades\Hash;
use App\Notifications\LoginTeachers;

class ProfesseursController extends Controller
{
    /**
     * Afficher la liste des enseignants.
     */
    public function ShowTeachers()
    {
        // Génération d'un matricule unique
        do {
            $newMatricule = Str::random(10);
        } while (User::where('matricule', $newMatricule)->exists());
    
        // Récupération des données nécessaires
       
        $user = User:: all();
        $sessions = Sessions::all();
        $professeurs = Professeurs::all();
        $grades =Grades::all();
        $specialites = Speciality::orderBy('name', 'asc')->get();
    
        return view('AdminPages.Enseignant', compact('user','grades', 'sessions', 'professeurs', 'newMatricule', 'specialites'));
    }

    /**
     * Ajouter un enseignant.
     */
  

    public function AddTeachers(Request $request)
    {
        $request->validate([
            'matricule' => 'required|unique:users',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'grade' => 'required|string|max:255',
            'sexe' => 'required|string|in:M,F',
            'specialities_ids' => 'nullable|array',  // Acceptation d'un tableau de spécialités
            'specialities_ids.*' => 'exists:specialities,id', // Vérification des IDs de spécialités existantes
            'phone' => 'required', // Validation du téléphone
        ], [
            'matricule.required' => 'Le matricule est obligatoire.',
            'matricule.unique' => 'Le matricule doit être unique.',
            'nom.required' => 'Le nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le prénom ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être valide.',
            'email.unique' => 'L\'email doit être unique.',
            'grade.required' => 'Le grade est obligatoire.',
            'grade.string' => 'Le grade doit être une chaîne de caractères.',
            'grade.max' => 'Le grade ne doit pas dépasser 255 caractères.',
            'sexe.required' => 'Le sexe est obligatoire.',
            'sexe.string' => 'Le sexe doit être une chaîne de caractères.',
            'sexe.in' => 'Le sexe doit être soit (Masculin) ou (Féminin).',
            'specialities_ids.array' => 'Les spécialités doivent être sous forme de tableau.',
            'specialities_ids.*.exists' => 'Une ou plusieurs spécialités sélectionnées n\'existent pas.',
            'phone.required' => 'Le champ téléphone est requis.',  // Message d'erreur pour téléphone
           
        ]);
        

        // Génération d'un mot de passe aléatoire
        //$motDePasse = Str::random(12); // Génère un mot de passe aléatoire de 12 caractères
        $motDePasse = 'password';

        // Création de l'utilisateur (ou récupération s'il existe déjà)
        $user = User::create([
            'email' => $request->input('email'),
            'matricule' => $request->input('matricule'),
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'password' => Hash::make($motDePasse), // Hash du mot de passe aléatoire
            'phone' => $request->input('phone'), // Ajout du téléphone
            'role' => '2',
        ]);

        // Récupérer les IDs des spécialités depuis la requête
        $specialityIds = $request->input('specialities_ids', []); // Par défaut, un tableau vide si rien n'est envoyé

        // Création du professeur
        $professeur = Professeurs::create([
            'user_id' => $user->id,  // Lier le professeur à l'utilisateur
            'grade' => $request->input('grade'),
            'sexe' => $request->input('sexe'),
            'specialities_ids' => json_encode($specialityIds), // Stocker les IDs des spécialités au format JSON
        ]);

        // Envoi de la notification à l'utilisateur
        /*
            $user->notify(new LoginTeachers(
                $request->input('nom'),
                $request->input('prenom'),
                $request->input('email'),
                $motDePasse // Envoie le mot de passe généré aléatoirement
            ));
        */

        // Retourner une réponse avec succès
        return redirect()->back()->with('success', 'Enseignant ajouté avec succès.');
    }

    
    /**
     * Supprimer un enseignant.
     */
    public function DeleteTeachers(Request $request, $id)
    {
        try {
            // Check if the Professeur and User exist based on the provided ID
            $professeur = Professeurs::where('user_id', $id)->firstOrFail();
            $user = User::where('id', $id)->firstOrFail();
    
            // Perform the deletion
            $professeur->delete();
            $user->delete();
    
            return response()->json(['message' => 'Professeur supprimé avec succès'], 200);
        } catch (\Exception $e) {
         
    
            return response()->json(['message' => 'Une erreur est survenue lors de la suppression', 'error' => $e->getMessage()], 500);
        }
    }
    

}