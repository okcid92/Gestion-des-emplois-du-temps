<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('programmes', function (Blueprint $table) {
            $table->id('id_programme');
            $table->string('intitule', 255);
            $table->foreignId('id_mention')->constrained('mentions', 'id_mention');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('programmes');
    }
};
