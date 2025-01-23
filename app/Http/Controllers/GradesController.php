<?php

namespace App\Http\Controllers;

use App\Models\Grades;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GradesController extends Controller
{
    public function ShowGrades()
    {
        $grades = Grades::all('*');
    
        return view('AdminPages.GradeEnseignant', compact('grades'));
    }

    public function AddGrades(Request $request)
    {
        $request->validate([
            'nom' => 'required|unique:grades',
        ], [
            'nom.required' => 'Le champ grade est requis.',
            'nom.unique' => 'Le grade existe déjà.',
        ]);

        $grade = new Grades([
            'nom' => $request->input('nom'),
        ]);

        $grade->save();

        return redirect()->back()->with('success', 'Grade enregistré.');
    }
    public function DeleteGrades(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:grades,id',
        ]);

        $specialite = Grades::find($request->id);
        $specialite->delete();

        return redirect()->back()->with('success', 'Grade supprimé avec succès.');
    }

    public function UpdateGrades(Request $request)
    {
        $gradeId = $request->id;

        $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('grades')->ignore($gradeId),
            ],
        ], [
            'nom.required' => 'Le nom est obligatoire',
            'nom.unique' => 'Le grade existe déjà',
        ]);

        $grade = Grades::findOrFail($gradeId);
        $grade->nom = $request->input('nom');
        $grade->save();

        return redirect()->back()->with('success', 'Grade mise à jour avec succès.');
    }
}
