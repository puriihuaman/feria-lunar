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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sede_stand_id')->constrained('sede_stands')->cascadeOnDelete();
            $table->date('reservation_date');
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('status', ['pending', 'paid', 'canceled', 'expired'])->default('pending');
            $table->string('name', 100)->nullable();
            $table->string('surname', 100)->nullable();
            $table->string('email', 60)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('key_code', 8)->nullable();
            $table->dateTime('confirmation_date')->nullable();
            $table->timestamps();

            $table->unique(['sede_stand_id', 'reservation_date'], 'unique_reserva');
            $table->index('reservation_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
