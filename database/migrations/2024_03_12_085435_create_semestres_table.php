<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('semestres', function (Blueprint $table) {
            $table->id('id_semestre');
            $table->string('libelle', 100);
            $table->foreignId('id_annee_academique')->constrained('annees_academiques', 'id_annee_academique');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('semestres');
    }
};
