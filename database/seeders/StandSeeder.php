<?php

namespace Database\Seeders;

use App\Models\Stand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        if (Stand::count() > 0) {
            return; // ya existen datos
        }

        $total_stands = 160;

        for ($i = 1; $i <= $total_stands; $i++) {
            $category = ($i <= 5 || ($i >= 21 && $i <= 25)) ? 'food' : 'standard';

            Stand::create([
                'booth_number' => $i,
                'category' => $category,
                'description' => "Stand número {$i} - 1 mesa - 1 silla",
                'is_active' => true,
            ]);
        }
    }
}
