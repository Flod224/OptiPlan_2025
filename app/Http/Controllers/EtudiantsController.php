<?php

namespace App\Http\Controllers;

use App\Models\Etudiants;
use App\Models\User;
use App\Notifications\Quittance;
use App\Notifications\TeachersMail;
use App\Notifications\LoginStudents;
use App\Models\Speciality;
use App\Models\Professeurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class EtudiantsController extends Controller
{
    public function ShowStudents()
    {
        $etudiants = Etudiants::with('user')->orderBy('created_at', 'asc')->get();
        $specialities = Speciality::all(); // Récupérer toutes les spécialités
        return view('AdminPages.Etudiant', compact('etudiants', 'specialities'));
    }  

    public function AddStudents(Request $request)
    {
        $request->validate([
            'matricule' => 'required|unique:users|string|max:20',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cycle' => 'required|string|max:50',
            'specialitie_id' => 'required',
            'phone' => 'required|unique:users', // Validation du téléphone
        ], [
            'matricule.required' => 'Le champ Matricule est requis.',
            'matricule.unique' => 'Le matricule existe déjà.',
            'matricule.max:20' => 'Le matricule ne doit pas depasser 20 caractères.',
            'email.unique' => 'Email existant.',
            'nom.required' => 'Le champ Nom est requis.',
            'prenom.required' => 'Le champ prénom est requis.',
            'email.required' => 'Le champ email est requis.',
            'cycle.required' => 'Le champ cycle est requis.',
            'cycle.string' => 'Le champ cycle doit être un string.',
            'specialitie_id.required' => 'Le champ spécialité est requis.',
            'phone.required' => 'Le champ téléphone est requis.',  // Message d'erreur pour téléphone
            'phone.unique' => 'Le numéro de téléphone existe déjà.', // Validation d'unicité pour le téléphone
            
        ]);

        //$motDePasse = Str::random(12); // Génère un mot de passe aléatoire de 12 caractères
        $motDePasse = 'password';

        $user = new User([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'email' => $request->input('email'),
            'matricule' => $request->input('matricule'),
            'phone' => $request->input('phone'), // Ajout du téléphone
            'password' => Hash::make($motDePasse),
        ]);

        $user->save();


        $specialityId = $request->input('specialitie_id');
        $userId = $user->id;
        
        $etudiant = new Etudiants([
            'user_id' => $userId,
            'niveau_etude' => $request->input('cycle'),
            'speciality_id' => $specialityId,
        ]);

        try {
            $etudiant->save();
            //$user->notify(new LoginStudents($user->nom, $user->prenom, $user->email, $motDePasse));
            return redirect()->back()->with('success', 'Étudiant ajouté avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de l\'étudiant : ' . $e->getMessage());
        }
    }
    public function UpdateStudents(Request $request, $id)
    {
        // Valider les données reçues
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'matricule' => 'required|string|max:20',
            'niveau_etude' => 'required|string|max:50',
            'speciality_id' => 'required|exists:specialities,id',
        ]);
    
        // Trouver l'étudiant et l'utilisateur associés
        $etudiant = Etudiants::where('id', $id)->firstOrFail();
        $userId = $etudiant->user_id;
        $user = User::where('id', $userId)->first();
    
        // Mettre à jour les informations de l'utilisateur
        $user->update([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'email' => $request->input('email'),
            'matricule' => $request->input('matricule'),
        ]);
    
        // Mettre à jour les informations de l'étudiant
        $etudiant->update([
            'niveau_etude' => $request->input('niveau_etude'),
            'speciality_id' => $request->input('speciality_id'),
        ]);
    
        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Étudiant mis à jour avec succès.');
    }
     
    public function DeleteStudents(Request $request, $id)
    {
        try {
            // Trouver l'utilisateur associé
            $user = User::findOrFail($id); // Récupérer l'utilisateur
            $etudiant = Etudiants::where('user_id', $id)->first(); // Vérifier l'étudiant lié
            
            if ($etudiant) {
                // Supprimer l'étudiant (et résoudre les relations, si nécessaires)
                $etudiant->delete();
            }
    
            // Supprimer l'utilisateur
            $user->delete();
    
            return response()->json(['message' => 'Étudiant supprimé avec succès'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Gestion des cas où l'utilisateur ou l'étudiant n'existe pas
            return response()->json(['message' => 'Étudiant ou utilisateur introuvable', 'error' => $e->getMessage()], 404);
        } catch (\Illuminate\Database\QueryException $e) {
            // Gestion des erreurs liées à la base de données (clés étrangères, etc.)
            return response()->json([
                'message' => 'Impossible de supprimer : contrainte de base de données',
                'error' => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            // Gestion des erreurs générales
            return response()->json([
                'message' => 'Une erreur est survenue lors de la suppression',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    


        
    public function updateStatus(Request $request)
    {
        $etudiantId = $request->input('etudiantId');
        $status = $request->input('status');
        $etudiant = Etudiants::where('user_id', $etudiantId)->first();

        if (!$etudiant) {
            return response()->json(['success' => false, 'message' => 'Étudiant non trouvé.']);
        }
        $is_ready_pre = $etudiant->is_ready ; 
        
        // ajouter la notification de l'etudiant si ses docs sont validé ici
        
        $etudiant->is_ready = $is_ready_pre + $status;
        $etudiant->save();

        return response()->json(['success' => true, 'message' => 'Statut de l\'étudiant mis à jour avec succès.']);
    }

    public function updateAllEtudiantsStatus(Request $request)
        {
            $status = $request->input('status'); // Statut à appliquer
            $type = $request->input('type');
        
            try {
                // Récupérer tous les étudiants avec is_ready == 3
                if ($type == 'Pre-Soutenance') {
                    $etudiants = Etudiants::where('is_ready', 3)->get();
                }
                else {
                    $etudiants = Etudiants::where('is_ready', 5)->get();
                }
                
        
                if ($etudiants->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Aucun étudiant trouvé.'
                    ]);
                }
        
                // Mettre à jour chaque étudiant
                foreach ($etudiants as $etudiant) {
                    $etudiant->is_ready += $status; // Incrémenter ou décrémenter selon le statut
                    $etudiant->save(); // Sauvegarder les modifications
                }
        
                return response()->json([
                    'success' => true,
                    'message' => 'Statut des étudiants mis à jour avec succès.'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage()
                ]);
            }
        }
    





    public function infosStudents(Request $request)
    {
        $etudiantId = Auth::id();
    
        // Récupérer l'étudiant correspondant à l'utilisateur connecté
        $etudiant = Etudiants::where('user_id', $etudiantId)->with('user')->firstOrFail();
    
        // Validation des données
        $request->validate([
            'theme' => 'required',
            'maitre_memoire' => 'required',
            'file' => [
                function ($attribute, $value, $fail) use ($etudiant) {
                    if (empty($etudiant->file) && !$value) {
                        $fail('Veuillez uploader le mémoire');
                    }
                },
                'file',
                'mimes:pdf',
                'max:10240',
            ],
        ], [
            'theme.required' => 'Veuillez renseigner votre thème.',
            'maitre_memoire.required' => 'Veuillez renseigner le nom de votre encadreur.',
            'file.mimes' => 'Le document doit être au format PDF.',
            'file.max' => 'La taille du document ne doit pas dépasser 10 Mo.',
        ]);
    
                // Mettre à jour les informations de l'étudiant
            $etudiant->theme = $request->input('theme');
            $etudiant->maitre_memoire = $request->input('maitre_memoire');

            // Vérifier si un mail doit être envoyé
            if ($etudiant->mail_prof == 0 || is_null($etudiant->maitre_memoire) || $etudiant->isDirty('maitre_memoire')) {
                try {
                    $professeur = $etudiant->professeur;
        
                    /* 
                        $professeur->user->notify(new TeachersMail(
                            $professeur->user->nom,
                            $professeur->user->prenom,
                            $etudiant->user->nom,
                            $etudiant->user->prenom,
                            $etudiant->theme,
                        ));
                   */

                    // Mettre à jour l'état `mail_prof` pour indiquer qu'un mail a été envoyé
                    $etudiant->mail_prof = 1;
                    
                } catch (\Exception $e) {
                  
                    return redirect()->back()->with('error', 'Une erreur est survenue. Vérifiez votre connexion internet.');
                }
            }

          
        
    
        // Gestion du fichier uploadé
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads');
            $fileName = basename($filePath);
            $etudiant->file = $fileName;
        }
    
        // Générer un QR code
        $contentQr = "Quittance authentique pour l'étudiant ".$etudiant->user->prenom." ".$etudiant->user->nom;
        $qrcode = base64_encode(QrCode::format('svg')->size(130)->generate($contentQr));
    
        // Envoyer la notification avec le PDF attaché
       /*
        $etudiant->user->notify(new Quittance(
                $etudiant->user->nom,
                $etudiant->user->prenom,
                $etudiant->user->matricule,
                $etudiant->theme,
                $etudiant->filiere,
                $etudiant->niveau_etude,
                $qrcode
            ));
        */

        $etudiant->is_ready = 1;
        
        // Mettre à jour les informations
        $etudiant->save();
    
        return redirect()->back()->with('success', 'Informations enregistrées avec succès !');
    }
    



    public function showPDF($filename)
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
    
    public function ChangePassword(Request $request)
    {
        
        // Récupération de l'utilisateur par son ID
        $user = User::findOrFail($request->id);
    
        // Validation des données reçues

        $request->validate([
            'old_password' => 'required',

            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/', // Au moins une lettre majuscule
                'regex:/[a-z]/', // Au moins une lettre minuscule
                'regex:/[0-9]/', // Au moins un chiffre
                'regex:/[@$!%*?&]/', // Au moins un symbole
            ],
            'confirmPassword'=> [
                'string',
                'min:8',
                'regex:/[A-Z]/', // Au moins une lettre majuscule
                'regex:/[a-z]/', // Au moins une lettre minuscule
                'regex:/[0-9]/', // Au moins un chiffre
                'regex:/[@$!%*?&]/', // Au moins un symbole
            ],
        ], [
            'old_password.required' => "Veuillez entrer l'ancien mot de passe",
            'password.required' => "Veuillez entrer le nouveau mot de passe",
            'password.min' => "Le mot de passe doit contenir au moins 8 caractères.",
            'password.regex' => "Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un symbole.",
        ]);
    
        // Vérification de l'ancien mot de passe
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['passwordnote' => 'Le mot de passe actuel est incorrect.']);
        }
    
        // Vérification si l'ancien et le nouveau mot de passe sont identiques
        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['passwordnote' => 'Le nouveau mot de passe ne doit pas être identique à l\'ancien.']);
        }
    
        // Mise à jour du mot de passe
        $user->update([
            'password' => Hash::make($request->password), // Hashage du mot de passe
            'changedPassword' => 1, // Indication que le mot de passe a été modifié
        ]);


    if ($user->role==0){
        // Redirection avec un message de succès
        return redirect()->route('StudentsDashboard')->with('success', 'Mot de passe modifié avec succès.');
    }
    else{ return redirect()->route('TeacherDasboard')->with('success', 'Mot de passe modifié avec succès.');
    }
    
}
}
