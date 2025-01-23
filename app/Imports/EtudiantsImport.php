<?php

namespace App\Imports;

use App\Models\Etudiants;
use App\Models\Grades;
use App\Models\Professeurs;
use App\Models\User;
use App\Models\Speciality;
use App\Notifications\LoginStudents;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class EtudiantsImport implements ToModel, WithStartRow, WithBatchInserts
{
    public function model(array $row)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');

        if (empty(array_filter($row))) {
            return null;
        }

        $existingStudent = User::where('email', $row[3])->first();
        $existingMatricule = User::where('matricule', $row[4])->first();

        $i = 1;
        if (!$existingStudent && !$existingMatricule) {

            //$motDePasse = Str::random(10);
            $motDePasse = 'password';


            // Créez un nouvel utilisateur
            $user = new User([
                'nom' => $row[1],
                'prenom' => $row[2],
                'email' => $row[3],
                'matricule' => $row[4],
                'phone' => '04631',
                'password' => Hash::make($motDePasse),
            ]);
            $user->save();
            $i++;
            $userId = $user->id;
            $specialityName = $row[5]; // Supposons que le nom de la spécialité est dans cette colonne
            $speciality = Speciality::where('name', $specialityName)->first();

            if ($speciality) {
                $specialityId = $speciality->id;
            } else {
                // Gérer le cas où la spécialité n'existe pas
                $specialityId = null; // Ou crée une nouvelle spécialité si nécessaire
            }

            $etudiant = new Etudiants([
                'user_id' => $userId,
                'niveau_etude' => $row[6], 
                'birthday' => $row[8],
                'speciality_id' => $specialityId,
                'theme' => $row[7],
                'confirm_prof' => true, // à verifier 
                'sendmail' => true,
                'mail_prof' => 0, //à verifier
                'is_ready' => 0
            ]);
            
            $etudiant->save();


            $user->notify(new LoginStudents($row[1], $row[2], $row[3], $motDePasse));
        }

        return null;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
