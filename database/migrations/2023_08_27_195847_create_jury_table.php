<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jury', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID comme clé primaire
            $table->uuid('examinateur'); // Utilisation de UUID au lieu de integer
            $table->foreign('examinateur')
                  ->references('id')
                  ->on('professeurs')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            $table->uuid('president'); // Utilisation de UUID pour la relation avec 'professeurs'
            $table->foreign('president')
                  ->references('id')
                  ->on('professeurs')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

            $table->uuid('rapporteur'); // Utilisation de UUID pour la relation avec 'professeurs'
            $table->foreign('rapporteur')
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
        Schema::dropIfExists('jury');
    }
}
