<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID comme clé primaire
            $table->string('nom')->nullable(); // Description de la session
            $table->date('session_start_PreSout'); // Date de début de la Présoutenance
            $table->date('session_end_PreSout'); // Date de fin de la Présoutenance
            $table->date('session_start_Sout'); // Date de début de la Souténance
            $table->date('session_end_Sout'); // Date de fin de la Souténance
            $table->integer('nb_soutenance_max_prof')->default(4); // Nombre max de soutenances par prof
            $table->float('grademin_licence')->default(2); // Note minimale pour la licence
            $table->float('grademin_master')->default(5); // Note minimale pour le master
            $table->timestamps(); // Colonnes created_at et updated_at
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
 
