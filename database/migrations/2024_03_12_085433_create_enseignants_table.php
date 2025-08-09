<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id('id_enseignant');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('grade', 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('enseignants');
    }
};
