<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Speciality; // Assurez-vous d'inclure le modèle

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Liste des spécialités
        $specialities = [
            'IA',
            'GL',
            'IM',
            'SEIoT',
            'SIRI',
            'SI',
        ];

        // Utiliser firstOrCreate pour insérer ou vérifier si la spécialité existe déjà
        foreach ($specialities as $speciality) {
            Speciality::firstOrCreate([
                'name' => $speciality, // Vérifie si une spécialité avec ce nom existe déjà
            ]);
        }
    }
}
