<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSallesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('salles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nom');
            $table->string('description')->nullable();
            $table->string('localisation')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('salles');
    }
};
