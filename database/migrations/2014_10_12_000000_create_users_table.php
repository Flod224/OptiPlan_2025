<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Utilisation d'un UUID comme clé primaire
            $table->string('nom')->nullable(); // Nom de l'utilisateur, peut être nul
            $table->string('prenom')->nullable(); // Prénom de l'utilisateur, peut être nul
            $table->string('email')->unique()->require(); // Email unique
            $table->string('matricule')->unique()->nullable(); // Matricule unique, peut être nul
            $table->string('sexe')->nullable(); 
            $table->string('phone')->nullable();
            $table->string('password'); // Mot de passe
            $table->boolean('changedPassword')->default(False); // Statut de changement de mot de passe
            $table->string('role')->default(false); // Rôle de l'utilisateur
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
