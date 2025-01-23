<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabilityTeachersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('availabilityTeachers', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID pour la clé primaire
            $table->date('jour'); // Date pour la disponibilité
            $table->uuid('prof_id'); // Référence vers la salle
            $table->uuid('session_id'); // Référence vers la session
            $table->uuid('horaire_id'); // Référence vers l'horaire
            $table->string('type_soutenance'); 
            $table->timestamps(); // Les timestamps créés_at et mis à jour_at




            $table->foreign('prof_id')
                  ->references('id')
                  ->on('professeurs')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            $table->foreign('session_id')
                    ->references('id')
                    ->on('sessions') // Assurez-vous que la table 'sessions' existe
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

            $table->foreign('horaire_id')
                    ->references('id')
                    ->on('horaires') // Assurez-vous que la table 'horaires' existe
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('availabilityTeachers');
    }
};
