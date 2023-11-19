<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('corps'); 
            $table->unsignedBigInteger('bouteille_id')->nullable(); 
            $table->foreign('bouteille_id')->references('id')->on('bouteilles'); 
            $table->unsignedBigInteger('bouteille_personnalisee_id')->nullable(); 
            $table->foreign('bouteille_personnalisee_id')->references('id')->on('bouteilles_personnalisees'); 
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
        Schema::dropIfExists('commentaires');
    }
}
