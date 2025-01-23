<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\BaseTest;
use App\Models\Etudiants;
use App\Notifications\Quittance;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class _4UserTest extends BaseTest
{
    /**
     * @return void
     * @test
    */

    public function it_stores_new_users()
    {
        $admin = $this->getAdminUser();
        $this->actingAs($admin);

        // Create a user using the factory
        $studentData = [
            [
                'matricule' => '123456',
                'nom' => 'HOUEHA',
                'prenom' => 'Karen',
                'email' => 'karenhoueha@gmail.com',
                'cycle' => 'Licence',
                'filiere' => 'GL'
            ],
            [
                'matricule' => '123457',
                'nom' => 'GUIDIMADJEGBE',
                'prenom' => 'Pacitte',
                'email' => 'balancementdeprojet9@gmail.com',
                'cycle' => 'Licence',
                'filiere' => 'IM'
            ],
        ];

        foreach ($studentData as $data) {
            $response = $this->post('/ajoutEtudiant', $data);
    
            // Assert that the user is added to the 'users' table
            $this->assertDatabaseHas('users', [
                'email' => $data['email'],
            ]);
    
            // Assert that the student is added to the 'etudiants' table
            $this->assertDatabaseHas('etudiants', [
                'niveau_etude' => $data['cycle'],
                'filiere' => $data['filiere'],
            ]);
    
            $response->assertRedirect()->assertSessionHas('success', 'Étudiant ajouté avec succès. Un e-mail a été envoyé avec les informations de connexion.');
        }
    }
}
