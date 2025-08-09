<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('materiels', function (Blueprint $table) {
            $table->id('id_materiel');
            $table->string('designation', 255);
            $table->integer('quantite')->default(0);
            $table->string('etat', 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materiels');
    }
};
