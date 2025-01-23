<?php

namespace Tests\Unit;

use App\Models\Etudiants;
use App\Models\User;
use App\Notifications\Quittance;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class _5UserUploadThesisTest extends TestCase
{
    /**
     * @return void
     * @test
     */

    public function test_infosStudents_with_file_upload()
    {
        $student =  [
            'matricule' => '123456',
            'nom' => 'HOUEHA',
            'prenom' => 'Karen',
            'email' => 'karenhoueha@gmail.com',
            'cycle' => 'Licence',
            'filiere' => 'GL'
        ];

        $user = User::where('email', $student['email'])->first();

        $this->actingAs($user);

        Storage::fake('uploads');
        $file = UploadedFile::fake()->create('memoire.pdf', 10240);

        $requestData = [
            'theme' => 'Thème du mémoire',
            'maitre_memoire' => 1,
            'file' => $file,
        ];

        $response = $this->post('/infosStudents', $requestData);

        $response->assertRedirect();

        $this->assertDatabaseHas('etudiants', [
            'theme' => 'Thème du mémoire',
            'maitre_memoire' => 1,
        ]);

    }
}


