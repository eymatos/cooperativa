<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SavingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Aportaciones (El ahorro obligatorio/normal)
        \App\Models\SavingType::create([
            'name' => 'Aportaciones',
            'code' => 'APO',
            'allow_withdrawals' => false, // No se puede retirar (regla general)
        ]);

        // 2. Ahorro Retirable (Para los retiros antiguos y el nuevo producto)
        \App\Models\SavingType::create([
            'name' => 'Ahorro Retirable',
            'code' => 'RET',
            'allow_withdrawals' => true, // Este sí permite retiros
        ]);
    }
}
