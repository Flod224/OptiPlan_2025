<?php

namespace App\Imports;

use App\Models\Grades;
use App\Models\Professeurs;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\LoginTeachers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SallesImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        if (empty(array_filter($row))) {
            return null;
        }

        $existingRoom = Salles::where('nom', $row[1])->first();
        $existingRoomLocalisation = Salles::where('localisation', $row[2])->first();

        if (!$existingRoom && !$existingRoomLocalisation) {

            $salles = new Salles([
                'nom' => $row[1],
                'localisation' => $row[2],
                'description' => $row[3], // Stocker les IDs des spécialités au format JSON
            ]);

            $salles->save();
        }
        return null; // Important pour les lignes sans traitement
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
