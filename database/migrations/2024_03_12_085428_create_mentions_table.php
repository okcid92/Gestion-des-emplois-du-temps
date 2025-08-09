<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mentions', function (Blueprint $table) {
            $table->id('id_mention');
            $table->string('nom', 255);
            $table->foreignId('id_domaine')->constrained('domaines', 'id_domaine');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mentions');
    }
};
