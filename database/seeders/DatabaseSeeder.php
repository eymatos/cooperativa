<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Socio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tipos de Ahorro
        $this->call(SavingTypeSeeder::class);

        // 2. ADMIN
        User::create([
            'name'     => 'Administrador Principal',
            'cedula'   => '00100000000',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('password'),
            'tipo'     => 2, 
        ]);

        // 3. SOCIOS (Usando TU estructura)
        $nombres = ['Juan', 'Maria', 'Pedro', 'Luisa', 'Carlos', 'Ana', 'Jose', 'Elena', 'Miguel', 'Laura'];
        $apellidos = ['Perez', 'Gomez', 'Diaz', 'Rodriguez', 'Hernandez', 'Martinez', 'Lopez', 'Garcia', 'Sanches', 'Romero'];

        for ($i = 0; $i < 10; $i++) {
            $cedula = '402' . str_pad($i + 1, 8, '0', STR_PAD_LEFT);
            $nom = $nombres[$i];
            $ape = $apellidos[$i];

            // A. Login
            $user = User::create([
                'name'     => "$nom $ape", 
                'cedula'   => $cedula,
                'email'    => strtolower($nom) . ".$i@test.com",
                'password' => Hash::make('password'),
                'tipo'     => 0,
            ]);

            // B. Perfil de Socio (CON TUS CAMPOS + SUELDO)
            Socio::create([
                'user_id'       => $user->id,
                'nombres'       => $nom,
                'apellidos'     => $ape,
                'telefono'      => '809-555-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'direccion'     => "Calle $i, Sector Los Prados",
                'ahorro_total'  => 0,
                // Datos para probar préstamos:
                'sueldo'        => rand(25000, 90000), 
                'lugar_trabajo' => 'Empresa Privada S.R.L.'
            ]);
        }
    }
}