<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoutiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soutiens', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->boolean('is_beneficie');
            $table->string('cadre');
            $table->text('sources');
            $table->double('montant_soutien_precedent')->nullable();
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
        Schema::dropIfExists('soutiens');
    }
}
