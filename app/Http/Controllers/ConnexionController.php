<?php

namespace App\Http\Controllers;

use App\Models\Etudiants;
use App\Models\Professeurs;
use App\Models\Soutenance;
use App\Models\User;
use App\Models\Sessions;
use App\Models\Horaires;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ConnexionController extends Controller
{
    public function LoginView()
    {
        return view('Authenticate.authenticate_light');
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('user')->attempt($credentials)) {

            if (auth()->user()->role == 1) {
                // Utilisateur est un superadmin, redirigez-le vers le tableau de bord admin
                return redirect()->intended('/choiceSession');
            }
            if (auth()->user()->role == 2) {
                // Utilisateur est un superadmin, redirigez-le vers le tableau de bord admin
                return redirect()->intended('/TeacherDasboard');
            }

            // Pour les utilisateurs normaux, redirigez-les vers le tableau de bord des étudiants
            return redirect()->intended('/StudentsDashboard');
        }

        return redirect()->back()->with('error', 'Adresse e-mail ou mot de passe incorrect.');
    }


    public function StudentsDashboard(){

        $user = auth()->user();
        //$all_user = User::all();
        $prof = Professeurs::with('user')->get();
        
        $etudiantId = Etudiants::where('user_id',$user->id)->value('id');
        $programmation = Soutenance::where('etudiant_id', $etudiantId)->first();
        if($user && $user->changedPassword == 1){
            return view('Students.StudentsDashboard', compact('user','prof','programmation'));
        }
        elseif($user && $user->changedPassword == 0){
            return view('Students.StudentsDashboardUpdateMdp');
        }
        else{
            return redirect()->route('login');
        }
    }

    public function TeacherDashboard()
    {
        $user = auth()->user();
        $horaire = Horaires::where('nom', 'LIKE', 'L%')->orderBy('debut')->get();
        $sessions = Sessions::orderBy('created_at', 'desc')->get();
        // Récupérer le professeur connecté
        $professeur = Professeurs::where('user_id', $user->id)->first();
    
        if (!$professeur) {
            return redirect()->route('login')->with('error', 'Vous n\'êtes pas un professeur.');
        }
    
        // Récupérer les étudiants assignés à ce professeur comme maître de mémoire
        $etudiants = Etudiants::where('maitre_memoire', $professeur->id)->with('user')->get();
    

        if($user && $user->changedPassword == 1){
            return view('TeacherPages.TeacherDashboard', compact('user','professeur','etudiants', 'sessions','horaire'));
        }
        elseif($user && $user->changedPassword == 0){
            return view('TeacherPages.ChangePasswords', compact('user','professeur','etudiants'));
        }
    }
    

    public function deconnexion()
    {
        if (auth()->check()) {
            Session::forget('selected_session_id');
            Auth::logout();
        }

        return redirect()->route('login');
    }
    
}
