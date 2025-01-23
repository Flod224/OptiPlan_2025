<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorairesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('horaires', function (Blueprint $table) {
            // Définir 'id' comme UUID et clé primaire
            $table->uuid('id')->primary();

            // Définir 'nom' comme unique si nécessaire (selon votre besoin)
            $table->string('nom')->unique();

            // Définir 'debut' et 'fin' comme des colonnes de type time sans unique()
            $table->time('debut');
            $table->time('fin');

            // Ajout des timestamps pour la gestion des dates de création et de mise à jour
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('horaires');
    }
};
