<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoutenanceTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('soutenance', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID comme clé primaire
            $table->date('jour');
            $table->string('state')->nullable();

            // Utilisation de UUID pour les relations
            $table->uuid('etudiant_id'); // Utilisation de UUID pour les clés étrangères
            $table->foreign('etudiant_id')
                  ->references('id')
                  ->on('etudiants')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            $table->uuid('jury_id'); // Utilisation de UUID pour les clés étrangères
            $table->foreign('jury_id')
                  ->references('id')
                  ->on('jury')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            $table->uuid('session_id'); // Utilisation de UUID pour les clés étrangères
            $table->foreign('session_id')
                  ->references('id')
                  ->on('sessions')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            $table->uuid('horaire_id'); // Utilisation de UUID pour les clés étrangères
            $table->foreign('horaire_id')
                  ->references('id')
                  ->on('horaires')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            $table->uuid('salle_id'); // Utilisation de UUID pour les clés étrangères
            $table->foreign('salle_id')
                  ->references('id')
                  ->on('salles')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('soutenance');
    }
};
