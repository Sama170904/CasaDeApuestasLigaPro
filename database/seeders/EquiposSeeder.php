<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EquiposSeeder extends Seeder
{
    public function run()
    {
        $equipos = [
            'Barcelona SC',
            'Emelec',
            'Liga de Quito',
            'Independiente del Valle',
            'Aucas',
            'El Nacional',
            'Delfín',
            'Universidad Católica',
            'Técnico Universitario',
            'Mushuc Runa',
            'Cumbayá',
            'Orense',
            'Libertad FC',
            'Imbabura SC'
        ];

        foreach ($equipos as $equipo) {
            DB::table('equipos')->insert([
                'nombre' => $equipo,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}

