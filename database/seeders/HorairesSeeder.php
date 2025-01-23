<?php

namespace Database\Seeders;

use App\Models\Horaires;
use Illuminate\Database\Seeder;

class HorairesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Horaires pour les Licences (1 heure)
        $licenceHoraires = [
            ['nom' => 'L1', 'debut' => '08:00:00', 'fin' => '09:00:00'],
            ['nom' => 'L2', 'debut' => '09:00:00', 'fin' => '10:00:00'],
            ['nom' => 'L3', 'debut' => '10:00:00', 'fin' => '11:00:00'],
            ['nom' => 'L4', 'debut' => '11:00:00', 'fin' => '12:00:00'],
            ['nom' => 'L5', 'debut' => '12:00:00', 'fin' => '13:00:00'],
            ['nom' => 'L6', 'debut' => '13:00:00', 'fin' => '14:00:00'],
            ['nom' => 'L7', 'debut' => '14:00:00', 'fin' => '15:00:00'],
            ['nom' => 'L8', 'debut' => '15:00:00', 'fin' => '16:00:00'],
            ['nom' => 'L9', 'debut' => '16:00:00', 'fin' => '17:00:00'],
            ['nom' => 'L10', 'debut' => '17:00:00', 'fin' => '18:00:00'],
        ];

        foreach ($licenceHoraires as $horaire) {
            Horaires::firstOrCreate($horaire);
        }

        // Horaires pour les Masters (1h30)
        $masterHoraires = [
            ['nom' => 'M1', 'debut' => '08:00:00', 'fin' => '09:30:00'],
            ['nom' => 'M2', 'debut' => '09:30:00', 'fin' => '11:00:00'],
            ['nom' => 'M3', 'debut' => '11:00:00', 'fin' => '12:30:00'],
            ['nom' => 'M4', 'debut' => '12:30:00', 'fin' => '14:00:00'],
            ['nom' => 'M5', 'debut' => '14:00:00', 'fin' => '15:30:00'],
            ['nom' => 'M6', 'debut' => '15:30:00', 'fin' => '17:00:00'],
        ];

        foreach ($masterHoraires as $horaire) {
            Horaires::firstOrCreate($horaire);
        }
    }
}
