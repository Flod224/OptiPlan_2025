<?php

namespace Tests;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BaseTest extends TestCase
{

    /**
     * @var User|null
     */
    protected static $adminUser;

    /**
     * Create or retrieve the admin user.
     *
     * @return User
     */
    protected function getAdminUser()
    {
        if (self::$adminUser === null) {
            self::$adminUser = User::factory()->create([
                'nom' => 'EDAH',
                'prenom' => 'Gaston',
                'email' => 'houehakaren@gmail.com',
                'matricule' => 'ADMIN58',
                'password' => 'gasedah',
                'role' => 1,
            ]);
        }

        return self::$adminUser;
    }

}
