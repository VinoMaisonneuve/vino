<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentairesBouteillesPersonnaliseesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commentaires_bouteilles_personnalisees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('corps'); 
            $table->unsignedBigInteger('bouteille_id')->nullable(); 
            $table->foreign('bouteille_id')->references('id')->on('bouteilles_personnalisees'); 
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
        Schema::dropIfExists('commentaires_bouteilles_personnalisees');
    }
}
