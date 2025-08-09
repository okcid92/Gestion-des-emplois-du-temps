<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('professor_id')->constrained('users');
            $table->foreignId('class_id')->constrained('classes');
            $table->date('day');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
