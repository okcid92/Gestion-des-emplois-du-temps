<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->id('id_cours');
            $table->string('intitule', 255);
            $table->text('description')->nullable();
            $table->foreignId('id_enseignant')->constrained('enseignants', 'id_enseignant');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cours');
    }
};
