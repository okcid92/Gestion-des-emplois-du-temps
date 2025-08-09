<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ligne_commandes', function (Blueprint $table) {
            $table->id('id_ligne');
            $table->foreignId('id_commande')->constrained('commandes', 'id_commande');
            $table->foreignId('id_materiel')->constrained('materiels', 'id_materiel');
            $table->integer('quantite');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ligne_commandes');
    }
};
