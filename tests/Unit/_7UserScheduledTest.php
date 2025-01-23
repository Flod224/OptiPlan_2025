<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\BaseTest;


class _7UserScheduledTest extends BaseTest
{
    /**
     * @test
     */
    public function user_scheduled()
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin);

        $schedulingData =  [
            'etudiant_id' => [2],
            'jour' => '2024-03-18',
            'horaire_id' => 1,
            'salle_id' => 1,
            'session_id' => 1,
            'president' => 2,
            'examinateur' => 3,
        ];
        $response = $this->post('/programmerPreSoutenance', $schedulingData);
  
        $this->assertDatabaseHas('soutenance',[
            'etudiant_id' => 1,
            'jour' => '2024-03-18',
            'horaire_id' => 1,
            'salle_id' => 1,
            'state' => 'pre'
        ]);

        $response->assertRedirect()->assertSessionHas('success', 'Pré-soutenance(s) programmée(s) avec succès.');
    }
}
