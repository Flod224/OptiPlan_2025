<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Tests\BaseTest;


class _6AvailabilityTest extends BaseTest
{
    /**
     * @test
     */
    public function availability()
    {
        $admin = $this->getAdminUser();

        // Acting as the admin user
        $this->actingAs($admin);

        $availabilityTeacherData = [
            [
                'prof_id' => [1,2,3],
                'jour' => '2024-06-03',
                'session_id' => 1,
                'type' => 'pre',
                'deb_fin' => ['H1','H2','H3']
            ],
            [
                'prof_id' => [1,2,3],
                'jour' => '2024-06-04',
                'session_id' => 1,
                'type' => 'pre',
                'deb_fin' => ['H1','H2','H3']
            ],
        ];

        foreach ($availabilityTeacherData as $data) {
                
            $response = $this->post('/addDisponibiliteEnseignant', $data);
    
            // Assert that the room is added to the database
            $this->assertDatabaseHas('availabilityTeachers', $data);
            $response->assertRedirect()->assertSessionHas('success', 'Enregistrée avec succès.');
        }   

        $availabilityRoomData = [
            [
                'salle_id' => [1],
                'jour' => '2024-03-18',
                'session_id' => 1,
                'type' => 'pre',
                'deb_fin' => ['H1','H2','H3']
            ],
            [
                'salle_id' => [1],
                'jour' => '2024-04-22',
                'session_id' => 1,
                'type' => 'sout',
                'deb_fin' => ['H1','H2','H3']
            ],
        ];

        foreach ($availabilityRoomData as $data) {
            $response = $this->post('/addDisponibiliteSalle', $data);
  
            // Assert that the room is added to the database
            $this->assertDatabaseHas('availabiltyRoom', $data);

            $response->assertRedirect()->assertSessionHas('success', 'Enregistrée avec succès.');
        }

    }
}
