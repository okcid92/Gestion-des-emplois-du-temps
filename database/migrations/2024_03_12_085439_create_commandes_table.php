<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id('id_commande');
            $table->date('date_commande');
            $table->foreignId('id_utilisateur')->constrained('users', 'id');
            $table->string('statut')->default('en_attente');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commandes');
    }
};
