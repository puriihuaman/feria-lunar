<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->string('key_code', 12)->nullable()->change();
            if (!Schema::hasColumn('reservas', 'key_code') || 
                !DB::getSchemaBuilder()->hasIndex('reservas', 'reservas_key_code_unique')) {
                $table->unique('key_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->string('key_code', 8)->nullable()->change();
        });
    }
};
