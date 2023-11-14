<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBouteillesPersonnaliseesCelliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bouteilles_personnalisees_celliers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('bouteille_id'); 
            $table->foreign('bouteille_id')->references('id')->on('bouteilles_personnalisees'); 
            $table->unsignedBigInteger('cellier_id'); 
            $table->foreign('cellier_id')->references('id')->on('celliers'); 
            $table->unsignedInteger('quantite');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bouteilles_personnalisees_celliers');
    }
}
