<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPrestamoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Normal',      'tasa_interes' => 18.00, 'plazo_defecto' => null], // Abierto
            ['nombre' => 'Escolar',     'tasa_interes' => 12.00, 'plazo_defecto' => 12],
            ['nombre' => 'Educativo',   'tasa_interes' => 12.00, 'plazo_defecto' => 12],
            ['nombre' => 'Vacacional',  'tasa_interes' => 22.00, 'plazo_defecto' => 12],
            ['nombre' => 'Express',     'tasa_interes' => 18.00, 'plazo_defecto' => 6],
        ];

        DB::table('tipo_prestamos')->insert($tipos);
    }
}