<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventosSeeder extends Seeder
{
    public function run()
    {
        $eventos = [
            [ 'equipo_local_id' => 1, 'equipo_visitante_id' => 2 ],
            [ 'equipo_local_id' => 3, 'equipo_visitante_id' => 4 ],
            [ 'equipo_local_id' => 5, 'equipo_visitante_id' => 6 ],
            [ 'equipo_local_id' => 7, 'equipo_visitante_id' => 8 ],
            [ 'equipo_local_id' => 9, 'equipo_visitante_id' => 10 ],
            [ 'equipo_local_id' => 11, 'equipo_visitante_id' => 12 ],
            [ 'equipo_local_id' => 13, 'equipo_visitante_id' => 14 ],
        ];

        foreach ($eventos as $evento) {
            DB::table('eventos')->insert([
                'equipo_local_id' => 1,
                'equipo_visitante_id' => 2,
                'fecha_evento' => now()->addDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

