<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salles', function (Blueprint $table) {
            // $table->id();
            $table->string('code_salle')->primary();
            $table->integer('type_salle');
            $table->integer('capacite');
            $table->integer('etage');
            $table->string('special');
            $table->timestamps();
            $table->foreign('type_salle')->references('id')->on('type_salles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salles');
    }
}