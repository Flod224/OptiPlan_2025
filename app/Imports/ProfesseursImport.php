<?php

namespace App\Imports;

use App\Models\Grades;
use App\Models\Professeurs;
use App\Models\User;
use App\Models\Speciality;
use App\Notifications\LoginTeachers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Log;

class ProfesseursImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        // Ignorer les lignes vides
        if (empty(array_filter($row))) {
            return null;
        }

        // Vérification de l'existence par email ou matricule
        $existingUserByEmail = User::where('email', $row[6])->first();
        $existingUserByMatricule = User::where('matricule', $row[4])->first();

        if (!$existingUserByEmail && !$existingUserByMatricule) {
            // Mot de passe par défaut
            //$defaultPassword = Str::random(10);
            $defaultPassword = 'password';

            // Créer un nouvel utilisateur
            $user = User::create([
                'nom' => $row[1],
                'prenom' => $row[2],
                'email' => $row[6],
                'matricule' => $row[7],
                'phone' => '046310',
                'role' => 2,
                'password' => Hash::make($defaultPassword),
            ]);

            // Récupérer les spécialités (exemple : "SIRI,IA,GL")
            $specialityNames = explode(',', $row[5]); // Les spécialités sont séparées par des virgules
            $specialityIds = [];

            foreach ($specialityNames as $specialityName) {
                $speciality = Speciality::where('name', trim($specialityName))->first();
                if ($speciality) { 
                    $specialityIds[] = $speciality->id; // Ajouter les IDs trouvés
                } else {
                    // Optionnel : journaliser si une spécialité n'est pas trouvée
                    Log::warning("Spécialité '{$specialityName}' non trouvée pour l'utilisateur {$row[1]} {$row[2]}.");
                }
            }

            // Récupérer ou créer le grade
            $grade = Grades::where('nom', $row[4])->first();
            if (!$grade) {
                Log::warning("Grade '{$row[4]}' non trouvé pour l'utilisateur {$row[1]} {$row[2]}.");
                $gradeId = null;
            } else {
                $gradeId = $grade->id;
            }

            // Créer un professeur
            $professeur = Professeurs::create([
                'user_id' => $user->id,
                'grade' => $gradeId,
                'specialities_ids' => json_encode($specialityIds), // Stocker les IDs des spécialités au format JSON
            ]);

            // Optionnel : envoyer une notification à l'utilisateur
            $user->notify(new LoginTeachers($row[1], $row[2], $row[6], $defaultPassword));
        }

        return null; // Important pour ignorer les lignes sans traitement
    }

    /**
     * Spécifie la ligne de démarrage (ignorer les en-têtes).
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Nombre de lignes à traiter par lot.
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * Nombre de lignes à lire par segment.
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
