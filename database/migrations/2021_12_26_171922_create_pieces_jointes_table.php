<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiecesjointesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pieces_jointes', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('extension')->nullable();
            $table->string('completeNameFile')->nullable();
            $table->string('name')->nullable();
            $table->foreignId('demandeur_id')->nullable()->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('pieces_jointes');

    }
}
