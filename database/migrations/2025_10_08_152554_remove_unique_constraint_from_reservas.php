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
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropUnique('unique_reserva');

            $table->index(['sede_stand_id', 'reservation_date'], 'idx_reserva_stand_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropIndex('idx_reserva_stand_date');
            $table->unique(['sede_stand_id', 'reservation_date'], 'unique_reserva');
        });
    }
};
