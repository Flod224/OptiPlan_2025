<?php

namespace Database\Seeders;

use App\Models\Grades; // Assurez-vous d'importer le modèle approprié
use Illuminate\Database\Seeder;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grades = [
            ['id' => 1, 'nom' => 'Ingénieur'],
            ['id' => 2, 'nom' => 'Docteur'],
            ['id' => 3, 'nom' => 'Assistant'],
            ['id' => 4, 'nom' => 'Maître Assistant'],
            ['id' => 5, 'nom' => 'Maître Conférence'],
            ['id' => 6, 'nom' => 'Professeur'],
        ];

        foreach ($grades as $grade) {
            Grades::firstOrCreate($grade);
        }
    }
}
