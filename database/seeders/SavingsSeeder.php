<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Socio;
use App\Models\SavingType;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use Carbon\Carbon;

class SavingsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Obtener los Tipos de Ahorro
        $tipoNormal = SavingType::where('code', 'aportacion')->first();
        $tipoRetirable = SavingType::where('code', 'voluntario')->first();

        if (!$tipoNormal || !$tipoRetirable) {
            $this->command->error('¡ERROR! Debes crear los tipos de ahorro primero (Aportación y Voluntario).');
            return;
        }

        // 2. Obtener los primeros 5 socios para pruebas
        $socios = Socio::take(5)->get();

        if ($socios->isEmpty()) {
            $this->command->warn('No hay socios creados. Crea algunos socios primero.');
            return;
        }

        $anio = 2025; // Año para generar la data

        foreach ($socios as $socio) {
            $this->command->info("Generando ahorros para: {$socio->nombres}...");

            // --- A. CUENTA NORMAL (APORTACIÓN) ---
            $cuentaNormal = SavingsAccount::firstOrCreate(
                ['socio_id' => $socio->id, 'saving_type_id' => $tipoNormal->id],
                ['balance' => 0, 'recurring_amount' => 1000] // Cuota fija de 1,000
            );

            // --- B. CUENTA RETIRABLE (VOLUNTARIO) ---
            $cuentaRetirable = SavingsAccount::firstOrCreate(
                ['socio_id' => $socio->id, 'saving_type_id' => $tipoRetirable->id],
                ['balance' => 0, 'recurring_amount' => 500] // Cuota fija de 500
            );

            // 3. Generar Transacciones Mensuales (Enero a Diciembre)
            for ($mes = 1; $mes <= 12; $mes++) {
                $fecha = Carbon::create($anio, $mes, 15); // Día 15 de cada mes

                // --- TRANSACCIONES NORMALES ---
                // 1. El depósito de nómina obligatorio
                $this->crearTransaccion($cuentaNormal, 'deposit', 1000, $fecha, 'Descuento Nómina');

                // 2. Un depósito extra ocasional (en Marzo y Julio)
                if ($mes == 3 || $mes == 7) {
                    $this->crearTransaccion($cuentaNormal, 'deposit', 2500, $fecha->copy()->addDays(2), 'Bono Extraordinario');
                }

                // --- TRANSACCIONES RETIRABLES ---
                // 1. Depósito voluntario mensual
                $this->crearTransaccion($cuentaRetirable, 'deposit', 500, $fecha, 'Ahorro Voluntario');

                // 2. Un retiro ocasional (Para probar los números rojos)
                // Digamos que en Agosto y Diciembre sacan dinero
                if ($mes == 8 || $mes == 12) {
                    $this->crearTransaccion($cuentaRetirable, 'withdrawal', 2000, $fecha->copy()->addDays(5), 'Retiro Parcial');
                }
            }

            // Actualizar balances finales reales en la cuenta (Sumar todo lo generado)
            $this->actualizarBalance($cuentaNormal);
            $this->actualizarBalance($cuentaRetirable);
        }
        
        $this->command->info('¡Data de prueba generada exitosamente!');
    }

    // Función auxiliar para crear transacciones rápido
    private function crearTransaccion($cuenta, $tipo, $monto, $fecha, $desc)
    {
        // Evitar duplicados si corres el seeder varias veces
        $existe = SavingsTransaction::where('savings_account_id', $cuenta->id)
                    ->where('date', $fecha->format('Y-m-d'))
                    ->where('description', $desc)
                    ->exists();

        if (!$existe) {
            SavingsTransaction::create([
                'savings_account_id' => $cuenta->id,
                'type' => $tipo,
                'amount' => $monto,
                'date' => $fecha,
                'description' => $desc
            ]);
        }
    }

    // Función para recalcular el balance total de la cuenta
    private function actualizarBalance($cuenta)
    {
        $depositos = $cuenta->transactions()->where('type', '!=', 'withdrawal')->sum('amount');
        $retiros = $cuenta->transactions()->where('type', 'withdrawal')->sum('amount');
        
        $cuenta->balance = $depositos - $retiros;
        $cuenta->save();
    }
}