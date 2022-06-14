<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnseignantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->bigInteger('matricule')->primary();
            $table->string('nom_prenom');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->text('password');
            $table->double('telephone')->nullable();
            $table->string('type_etat');
            $table->integer('type_status');
            $table->integer('code_dp');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('type_status')->references('id')->on('status');
            $table->foreign('code_dp')->references('id')->on('departements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enseignants');
    }
}