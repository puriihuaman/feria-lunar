<?php

namespace Database\Seeders;

use App\Models\Sede;
use App\Models\SedeStand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SedeStandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        if (SedeStand::count() > 0) {
            return;
        }

        // Configuración de sedes y precios
        $sedesConfig = [
            [
                'short_title' => 'sede-apupal',
                'number_of_stands' => 68,
                'base_price' => 80.00,
                'expensive_price' => 120.00,
            ],
            [
                'short_title' => 'sede-surco',
                'number_of_stands' => 146,
                'base_price' => 80.00,
                'expensive_price' => 130.00,
            ],
        ];

        foreach ($sedesConfig as $config) {
            $sede = Sede::where('short_title', $config['short_title'])->first();

            if (!$sede) {
                continue;
            }

            for ($i = 1; $i <= $config['number_of_stands']; $i++) {
                $price = ($i <= 5 || ($i >= 21 && $i <= 25)) 
                    ? $config['expensive_price'] 
                    : $config['base_price'];

                SedeStand::create([
                    'sede_id' => $sede->id,
                    'stand_id' => $i, // ojo: corresponde al booth_number del Stand creado antes
                    'price' => $price,
                    'is_active' => true,
                ]);
            }
        }

    }
}
