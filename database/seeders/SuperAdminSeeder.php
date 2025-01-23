<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::firstOrCreate(
            ['matricule' => 'ADMIN58'], // Cherche par email
            [
            'nom' => 'EDAH',
            'prenom' => 'Gaston',
            'email' => 'afomasse@gmail.com',
            'matricule' => 'ADMIN58',
            'password' => bcrypt('test'),
            'role' => 1
        ]);

        User::firstOrCreate(

            ['matricule' => 'ADMIN001',], 
        
            [
                'nom' => 'admin', //env('SUPER_USER_NAME'),
                'prenom'=>'admin', //env('SUPER_USER_NAME'),
                'email' => 'admin@example.com', // env('SUPER_USER_EMAIL')
                'matricule' => 'ADMIN001', //env('SUPER_USER_MATRICULE')
                'password' => bcrypt('admin'), //bcrypt(env('SUPER_USER_PASSWORD'))
                'role' => 1, 

            ]
        );

    }
}
