<?php

namespace Database\Seeders;

use App\Models\Sede;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SedeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        if (Sede::count() > 0) {
            return; // ya existen datos, no duplicar
        }

        $sedes = [
            [
                'title' => 'Sede Apupal - Los Olivos',
                'short_title' => 'sede-apupal',
                'address' => 'Av. Las Palmeras 3943, Los Olivos. Referencia: A 1 cdra de la Municipalidad',
                'capacity' => 68,
                'is_active' => true,
            ],
            [
                'title' => 'Sede B - Surco',
                'short_title' => 'sede-surco',
                'address' => 'Av. Los Aires, Surco. Referencia: A 1/2 cdra de Tottus',
                'capacity' => 146,
                'is_active' => true,
            ],
        ];

        foreach($sedes as $sede) {
            Sede::create($sede);
        }
    }
}
