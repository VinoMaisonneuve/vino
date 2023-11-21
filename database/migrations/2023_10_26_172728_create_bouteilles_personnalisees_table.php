<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBouteillesPersonnaliseesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bouteilles_personnalisees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nom');
            $table->string('pays')->nullable(); 
            $table->string('region')->nullable(); 
            $table->string('couleur')->nullable(); 
            $table->string('format')->nullable(); 
            $table->decimal('prix')->nullable(); 
            $table->string('producteur')->nullable(); 
            $table->unsignedSmallInteger('millesime')->nullable(); 
            $table->string('cepage')->nullable(); 
            $table->string('degre')->nullable(); 
            $table->string('type')->nullable(); 
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bouteilles_personnalisees');
    }
}
