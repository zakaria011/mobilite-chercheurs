<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_stages', function (Blueprint $table) {
            $table->id();
            $table->string('intitule_projet');
            $table->string('respo_marocain');
            $table->string('respo_etranger');
            $table->string('cadre');
            $table->string('reference');
            $table->boolean('is_rem');
            $table->foreignId('demande_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('mission_stages');
    }
}
