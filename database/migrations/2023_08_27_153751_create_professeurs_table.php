<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreateProfesseursTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('professeurs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('specialities_ids')->nullable();
            $table->uuid('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
 
            $table->unsignedInteger('grade');
            $table->foreign('grade')
                  ->references('id')
                  ->on('grades')
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
        Schema::dropIfExists('professeurs');
    }
};
 