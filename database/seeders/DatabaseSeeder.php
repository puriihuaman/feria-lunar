<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Administrador',
            'email' => 'ferialunar@ferialunar.com',
            'password' => Hash::make('@feriaLUNAR#2025'),
            'is_admin' => true
        ]);

        $this->call(
            [
                SedeSeeder::class,
                StandSeeder::class,
                SedeStandSeeder::class
            ]
        );
    }
}
