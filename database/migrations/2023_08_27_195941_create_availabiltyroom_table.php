<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabiltyRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availabiltyRoom', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID pour la clé primaire
            $table->date('jour'); // Date pour la disponibilité
            $table->uuid('salle_id'); // Référence vers la salle
            $table->uuid('session_id'); // Référence vers la session
            $table->uuid('horaire_id'); // Référence vers l'horaire
            $table->string('type_soutenance'); 
            $table->timestamps(); // Les timestamps créés_at et mis à jour_at

            // Définir les relations étrangères
            $table->foreign('salle_id')
                ->references('id')
                ->on('salles') // Assurez-vous que la table 'salles' existe
                ->onDelete('restrict') // Comportement en cas de suppression
                ->onUpdate('restrict'); // Comportement en cas de mise à jour

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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availabiltyRoom');
    }
}
