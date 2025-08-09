<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('annees_academiques', function (Blueprint $table) {
            $table->id('id_annee_academique');
            $table->integer('annee_debut');
            $table->integer('annee_fin');
            $table->timestamps();
            $table->softDeletes();
            
            // Ajouter une contrainte unique pour éviter les doublons
            $table->unique(['annee_debut', 'annee_fin']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('annees_academiques');
    }
};
