<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->string('intitule');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->date('date_depart');
            $table->date('date_retour');
            $table->boolean('is_mission');
            $table->string('pays');
            $table->string('ville');
            $table->foreignId('demandeur_id')->constrained()->onDelete('cascade');
            //$table->foreignId('etat_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demandes');
    }
}
