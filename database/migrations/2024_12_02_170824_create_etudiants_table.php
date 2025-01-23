<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtudiantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Définir 'id' comme UUID
            $table->uuid('user_id')->require(); // Clé étrangère UUID pour user
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            $table->string('niveau_etude');
            $table->string('birthday')->nullable();
            $table->string('file')->nullable();
            $table->string('theme')->nullable();
            $table->boolean('confirm_prof')->default(true);
            $table->boolean('sendmail')->default(false);
            $table->boolean('mail_prof')->default(false);
            $table->integer('is_ready')->default(0);

            // Ajout de la colonne speciality_id en UUID
            $table->uuid('speciality_id')->require();
            $table->foreign('speciality_id')
                  ->references('id')
                  ->on('specialities')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            // Clé étrangère UUID pour maitre_memoire
            $table->uuid('maitre_memoire')->nullable();
            $table->foreign('maitre_memoire')
                  ->references('id')
                  ->on('professeurs')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
};
