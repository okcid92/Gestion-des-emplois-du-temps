<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('scolarite', function (Blueprint $table) {
            $table->id('id_scolarite');
            $table->foreignId('id_etudiant')->constrained('etudiants', 'id_etudiant');
            $table->foreignId('id_annee_academique')->constrained('annees_academiques', 'id_annee_academique');
            $table->string('statut', 50);
            $table->timestamps();
            $table->softDeletes();

            // Ajouter une contrainte unique pour éviter les doublons
            $table->unique(['id_etudiant', 'id_annee_academique']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('scolarite');
    }
};
