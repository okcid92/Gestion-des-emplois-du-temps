<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('emploi_du_temps', function (Blueprint $table) {
            $table->id('id_emploi');
            $table->foreignId('id_cours')->constrained('cours', 'id_cours');
            $table->foreignId('id_semestre')->constrained('semestres', 'id_semestre');
            $table->date('jour'); // Stocké comme date pour permettre la conversion des jours
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->timestamps();
            $table->softDeletes();

            // Ajouter un index pour améliorer les performances des requêtes par jour
            $table->index('jour');
        });
    }

    public function down()
    {
        Schema::dropIfExists('emploi_du_temps');
    }
};
