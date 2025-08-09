<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            // Modifier la colonne day en string pour stocker les jours en anglais
            $table->string('day')->change();
            
            // Rendre la colonne room nullable car nous utilisons maintenant salle_id
            $table->string('room')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            // Restaurer les colonnes à leur état d'origine
            $table->date('day')->change();
            $table->string('room')->nullable(false)->change();
        });
    }
};
