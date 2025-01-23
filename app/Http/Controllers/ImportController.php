<?php

namespace App\Http\Controllers;

use App\Imports\ProfesseursImport;
use App\Imports\EtudiantsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $file = $request->file('fileStudents');
        

        //\Log::info('Resolved File Path:', ['path' => $file->getRealPath()]);
        if (!$request->file('fileStudents')->isValid() || !in_array($request->file('fileStudents')->getClientOriginalExtension(), ['xls', 'xlsx', 'csv'])) {
            dd($request->file('fileStudents')->getErrorMessage());
            return redirect()->back()->with('error', 'Le fichier fourni n\'est pas un fichier Excel valide.');
        }
        
        $columns = Excel::toArray([], $file)[0][0];
    
        $requiredColumns = ['ID_Student', 'Nom', 'Prénoms', 'Emails', 'Matricule_Number', 'Speciality','Degree_Attempted','Memory_title','Date et lieu de naissance'];
        $missingColumns = array_diff($requiredColumns, $columns);
    
        if (!empty($missingColumns)) {
            $missingColumnsText = implode(', ', $missingColumns);
            return redirect()->back()->with('error', "Les colonnes suivantes sont manquantes dans le fichier : $missingColumnsText.");
        }
        
        try {
            Excel::import(new EtudiantsImport, $file);
            return redirect()->back()->with('success', 'Importation réussie. Un mail de connexion a été envoyé aux étudiants.');
        
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'importation : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue . Veuillez vérifier votre connexion.');
        }
        
    }
    public function importTeachers(Request $request)
    {
        if (!$request->hasFile('fileTeachers')) {
            return redirect()->back()->with('error', 'Veuillez sélectionner un fichier.');
        }
        
        $file = $request->file('fileTeachers');

        // Charger le fichier Excel et obtenir les noms des colonnes
        $columns = Excel::toArray([], $file)[0][0];

        // Vérifier si les colonnes nécessaires sont présentes
        $requiredColumns = ['Nom', 'Prénoms', 'emails', 'Grade', 'Speciality',];
        $missingColumns = array_diff($requiredColumns, $columns);

        if (!empty($missingColumns)) {
            $missingColumnsText = implode(', ', $missingColumns);
            return redirect()->back()->with('error', "Les colonnes suivantes sont manquantes dans le fichier : $missingColumnsText.");
        }

        Excel::import(new ProfesseursImport, $file);
        
        return redirect()->back()->with('success', 'Importation réussie. ');

    }


}
