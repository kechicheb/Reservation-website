<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->double('matricule');
            $table->string('code_salle');
            $table->integer('code_creneau');
            $table->date('date_reservation');
            $table->string('attente');
            $table->timestamps();
            $table->foreign('code_salle')->references('code_salle')->on('salles');
            $table->foreign('matricule')->references('matricule')->on('users');
            $table->foreign('code_creneau')->references('id')->on('creneaus');



            // $table->primary(['code_reservation', 'matricule','code_salle','code_cr','date_reservation']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}