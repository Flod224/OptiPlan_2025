<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\BaseTest;

class _2SettingsTest extends BaseTest
{
    /**
     * @test
     */

    public function general_settings()
    {
        $admin = $this->getAdminUser();

        $this->actingAs($admin);

        $horaireData = [
            [
                'nom' => 'H1',
                'debut' => '08:00:00',
                'fin' => '09:00:00',
            ],
            [
                'nom' => 'H2',
                'debut' => '09:00:00',
                'fin' => '10:00:00',
            ],
            [
                'nom' => 'H3',
                'debut' => '10:00:00',
                'fin' => '11:00:00',
            ],
            [
                'nom' => 'H4',
                'debut' => '11:00:00',
                'fin' => '12:00:00',
            ],
            [
                'nom' => 'H5',
                'debut' => '12:00:00',
                'fin' => '13:00:00',
            ],
            [
                'nom' => 'H6',
                'debut' => '13:00:00',
                'fin' => '14:00:00',
            ],
            [
                'nom' => 'H7',
                'debut' => '14:00:00',
                'fin' => '15:00:00',
            ],
            [
                'nom' => 'H8',
                'debut' => '15:00:00',
                'fin' => '16:00:00',
            ],
            [
                'nom' => 'H9',
                'debut' => '16:00:00',
                'fin' => '17:00:00',
            ],
            [
                'nom' => 'H10',
                'debut' => '17:00:00',
                'fin' => '18:00:00',
            ],
        ];

        foreach ($horaireData as $data) {
            $response = $this->post('/horaireAdd', $data);
  
            // Assert that the room is added to the database
            $this->assertDatabaseHas('horaires', $data);

            $response->assertRedirect()->assertSessionHas('success', 'Horaire enregistré.');
        }

        $salleData = [
            [
                'nom' => 'Salle ISA(FSA)',
            ],
            [
                'nom' => 'Salle MOOCs',
            ],
        ];
    
        foreach ($salleData as $data) {
            $response = $this->post('/salleAdd', $data);
  
            // Assert that the room is added to the database
            $this->assertDatabaseHas('salles', $data);

            $response->assertRedirect()->assertSessionHas('success', 'Salle enregistrée.');
        }

        // Session data to be used in the test
        $sessionData = [
            'description' => 'Vague de juin 2024',
            'session_start' => '2024-06-24',
            'session_end' => '2024-06-26',
            'cycle'=>'Licence',
        ];
    
        // Make a POST request to add a new session
        $response = $this->post('/sessionAdd', $sessionData);
    
        // Assert that the session was added to the database
        $this->assertDatabaseHas('sessions', $sessionData);
    
        // Assert the response is a redirect back
        $response->assertRedirect()->assertSessionHas('success', 'Session enregistrée.');

        $gradeData = [
            [
                'nom' => 'Professeur',
            ],
            [
                'nom' => 'Docteur',
            ],
            [
                'nom' => 'Ingénieur',
            ],

        ];
    
        foreach ($gradeData as $data) {
            $response = $this->post('/ajoutGrades', $data);
  
            // Assert that the room is added to the database
            $this->assertDatabaseHas('grades', $data);

            $response->assertRedirect()->assertSessionHas('success', 'Grade enregistré.');
        }

        $profData = [
            [
                'matricule' => 'sfghjg',
                'nom' => 'HOUNDJI',
                'prenom' => 'Ratheil',
                'email' => 'houehakaren@gmail.com',
                'grade' => 2,
                'sexe' => 'M',
                'specialite' => 'GL-SI-IM'
            ],
            [
                'matricule' => 'xnjhdfvw',
                'nom' => 'EZIN',
                'prenom' => 'Eugène',
                'email' => 'karenhoueha@gmail.com',
                'grade' => 1,
                'sexe' => 'M',
                'specialite' => 'GL-IM'
            ],
            [
                'matricule' => 'xcvbniuy',
                'nom' => 'GNONLONFOUN',
                'prenom' => 'Miranda',
                'email' => 'balancementdeprojet9@gmail.com',
                'grade' => 3,
                'sexe' => 'F',
                'specialite' => 'GL-SI-IM'
            ],
        ];

        foreach ($profData as $data) {
            $response = $this->post('/ajoutProfesseur', $data);
  
            // Assert that the room is added to the database
            $this->assertDatabaseHas('professeurs', $data);

            $response->assertRedirect()->assertSessionHas('success', 'Enseignant ajouté avec succès.');
        }
    
    }
    
}
