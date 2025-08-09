<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->foreignId('salle_id')->nullable()->after('class_id')->constrained('salles')->onDelete('set null');
            // On garde temporairement l'ancienne colonne room pour la migration des données
            $table->string('old_room')->nullable()->default(null);
        });
    }

    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['salle_id']);
            $table->dropColumn('salle_id');
            $table->renameColumn('old_room', 'room');
        });
    }
};
