<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationMaterielsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_materiels', function (Blueprint $table) {
            $table->id();
            $table->integer('code_reservation');
            $table->integer('code_materiel');
            $table->timestamps();
            $table->foreign('code_reservation')->references('id')->on('reservations');
            $table->foreign('code_materiel')->references('id')->on('materiels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_materiels');
    }
}