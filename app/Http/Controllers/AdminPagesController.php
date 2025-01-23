<?php

namespace App\Http\Controllers;

use App\Notifications\NommerAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Etudiants;
use App\Models\User;
use App\Models\Professeurs;
use App\Models\Sessions;
use App\Models\Soutenance;
use App\Models\Horaires;
use App\Models\Grades;


class AdminPagesController extends Controller
{
    public function choiceSession(){
        $sessions = Sessions::orderBy('created_at', 'desc')->get();
        $grades = Grades::All();
        return view('AdminPages.ChoiceSession', compact('sessions','grades'));
    }
    
    public function infos($session_id){

        $professeurs = Professeurs::all('*');
        $etudiants = Etudiants::all('*');
        $nombreTotalEtudiants = User::where('role', 0)->count();
        
        Session::put('selected_session_id', $session_id);

        $nombreTotalEtudiantsEnPre = Soutenance::where('session_id', $session_id)->where('type','Pre-Soutenance')->count();
        $nombreTotalEtudiantsEnSout = Soutenance::where('session_id', $session_id)->where('type','Soutenance')->count();
        
        $nombreTotalProfesseurs = Professeurs::count();
        $sessions = Sessions::all('*');
        $sessionActive = Sessions::where('id',$session_id)->first();
        $soutenancesGroupedByExaminateurPresident=[];
        $filieresParExaminateurPresident = '';
        $value = 'PROGRAMME';
        $month = 'XXXXXXXXXX';
        $year = 'XXXX';
        $idSess = '';
        $type = '';

        return view('AdminPages.AdminDashboard', compact('idSess','sessionActive',
        'type','soutenancesGroupedByExaminateurPresident', 'filieresParExaminateurPresident',
        'professeurs','nombreTotalEtudiants','nombreTotalEtudiantsEnSout','nombreTotalEtudiantsEnPre',
        'nombreTotalProfesseurs','sessions','value','month','year'));
    }

    public function infosSoutenances(Request $request) {
        $jourSoutenance = $request->input('jour');
        $typeSoutenance = $request->input('type');
    
        if (!$jourSoutenance || !$typeSoutenance) {
            return response()->json(['error' => 'Veuillez sélectionner un jour et un type de soutenance']);
        }
    
        $soutenances = Soutenance::whereHas('horaire', function ($query) use ($jourSoutenance) {
            $query->where('jour', $jourSoutenance);
        })->where('type', $typeSoutenance)->get();
    
        if ($soutenances->isEmpty()) {
            return response()->json(['error' => 'Aucune soutenance trouvée pour ce jour et ce type']);
        }
    
        return response()->json(['soutenances' => $soutenances]);
    }
    public function getEtudiantData($etudiantId) {

        $etudiant = Etudiants::find($etudiantId);

        if (!$etudiant) {
            return response()->json(['error' => 'Étudiant non trouvé'], 404);
        }

        return response()->json(['etudiant' => $etudiant]);

    }
    public function getHoraireData($horaireId) {

        $horaire = Horaires::find($horaireId);

        if (!$horaire) {
            return response()->json(['error' => 'Horaire non trouvé'], 404);
        }

        return response()->json(['horaire' => $horaire]);
    }
    public function nommerAdmin(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|unique:users',
        ], [
            'email.unique' => 'Email existant.',
            'nom.required' => 'Le champ Nom est requis.',
            'prenom.required' => 'Le champ prénom est requis.',
            'email.required' => 'Le champ email est requis.',
        ]);
        $motDePasse = Str::random(10);
        $matricule = "ADMIN" . (random_int(59, 200));
        $role = 1;

        $user = new User([
            'nom' => $request->input('nom'),
            'prenom' => $request->input('prenom'),
            'email' => $request->input('email'),
            'matricule' => $matricule,
            'password' => Hash::make($motDePasse),
            'role' => $request->input('role'),
        ]);
        $user->save();

        try {
            $user->notify(new NommerAdmin($user->nom, $user->prenom, $user->email, $motDePasse));
            return redirect()->back()->with('success', 'Ajouté avec succès. Un e-mail a été envoyé avec les informations de connexion.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue . Vérifiez votre connexion internet .');
        }

    }
}
