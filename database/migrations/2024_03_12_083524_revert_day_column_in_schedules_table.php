<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            // D'abord, créer une nouvelle colonne temporaire
            $table->date('new_day')->nullable();
        });

        // Convertir les jours en dates
        DB::statement("
            UPDATE schedules 
            SET new_day = CASE day
                WHEN 'Monday' THEN DATE_ADD(CURDATE(), INTERVAL (1 - DAYOFWEEK(CURDATE())) DAY)
                WHEN 'Tuesday' THEN DATE_ADD(CURDATE(), INTERVAL (2 - DAYOFWEEK(CURDATE())) DAY)
                WHEN 'Wednesday' THEN DATE_ADD(CURDATE(), INTERVAL (3 - DAYOFWEEK(CURDATE())) DAY)
                WHEN 'Thursday' THEN DATE_ADD(CURDATE(), INTERVAL (4 - DAYOFWEEK(CURDATE())) DAY)
                WHEN 'Friday' THEN DATE_ADD(CURDATE(), INTERVAL (5 - DAYOFWEEK(CURDATE())) DAY)
                WHEN 'Saturday' THEN DATE_ADD(CURDATE(), INTERVAL (6 - DAYOFWEEK(CURDATE())) DAY)
                WHEN 'Sunday' THEN DATE_ADD(CURDATE(), INTERVAL (7 - DAYOFWEEK(CURDATE())) DAY)
            END
        ");

        Schema::table('schedules', function (Blueprint $table) {
            // Supprimer l'ancienne colonne
            $table->dropColumn('day');
        });

        Schema::table('schedules', function (Blueprint $table) {
            // Renommer la nouvelle colonne
            $table->renameColumn('new_day', 'day');
            // Ajouter la contrainte NOT NULL
            $table->date('day')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            // Créer une nouvelle colonne temporaire
            $table->string('new_day')->nullable();
        });

        // Convertir les dates en jours de la semaine
        DB::statement("
            UPDATE schedules 
            SET new_day = DAYNAME(day)
        ");

        Schema::table('schedules', function (Blueprint $table) {
            // Supprimer l'ancienne colonne
            $table->dropColumn('day');
        });

        Schema::table('schedules', function (Blueprint $table) {
            // Renommer la nouvelle colonne
            $table->renameColumn('new_day', 'day');
            // Ajouter la contrainte NOT NULL
            $table->string('day')->nullable(false)->change();
        });
    }
};
