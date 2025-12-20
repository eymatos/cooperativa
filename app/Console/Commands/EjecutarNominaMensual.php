<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{Socio, SavingsTransaction, Cuota, SavingsAccount, User};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EjecutarNominaMensual extends Command
{
    protected $signature = 'nomina:ejecutar {fecha? : La fecha del proceso YYYY-MM-DD}';
    protected $description = 'Procesa ahorros recurrentes y cobros de préstamos (Día 19 de cada mes)';

    public function handle()
    {
        // 1. IMPORTANTE: Autenticamos un usuario para evitar errores en activity_logs
        // Usamos el ID 1 (o el ID de tu usuario Administrador principal)
        $admin = User::where('tipo', 2)->first();
        if ($admin) {
            Auth::login($admin);
        }

        $fechaProceso = $this->argument('fecha') ? Carbon::parse($this->argument('fecha')) : now();
        $mes = $fechaProceso->month;
        $anio = $fechaProceso->year;

        $this->info("=== PROCESO DE NÓMINA: {$fechaProceso->format('d-m-Y')} ===");

        $socios = Socio::where('activo', true)->with(['cuentas', 'prestamos'])->get();

        DB::beginTransaction();
        try {
            foreach ($socios as $socio) {
                // 1. PROCESAR AHORROS RECURRENTES
                foreach ($socio->cuentas as $cuenta) {
                    if ($cuenta->recurring_amount > 0) {
                        $yaExiste = SavingsTransaction::where('savings_account_id', $cuenta->id)
                            ->whereMonth('date', $mes)
                            ->whereYear('date', $anio)
                            ->where('type', 'deposit')
                            ->exists();

                        if (!$yaExiste) {
                            SavingsTransaction::create([
                                'savings_account_id' => $cuenta->id,
                                'type' => 'deposit',
                                'amount' => $cuenta->recurring_amount,
                                'date' => $fechaProceso,
                                'description' => "Aporte mensual automático (Día 19) - " . $fechaProceso->format('M Y')
                            ]);

                            $cuenta->increment('balance', $cuenta->recurring_amount);
                        }
                    }
                }

                // 2. PROCESAR COBRO DE PRÉSTAMOS
                foreach ($socio->prestamos->where('estado', 'activo') as $prestamo) {
                    $cuotaMes = $prestamo->cuotas()
                        ->whereMonth('fecha_vencimiento', $mes)
                        ->whereYear('fecha_vencimiento', $anio)
                        ->where('estado', 'pendiente')
                        ->first();

                    if ($cuotaMes) {
                        $cuotaMes->update([
                            'abonado' => $cuotaMes->monto_total,
                            'estado' => 'pagada'
                        ]);

                        $prestamo->decrement('saldo_capital', $cuotaMes->capital);

                        if ($prestamo->saldo_capital <= 0.05) {
                            $prestamo->saldo_capital = 0;
                            $prestamo->estado = 'pagado';
                        }

                        $prestamo->save(); // Aseguramos persistencia

                        $this->line(" ✅ Cobrada cuota {$cuotaMes->numero_cuota} de {$socio->nombres} ({$prestamo->numero_prestamo})");
                    }
                }
            }

            DB::commit();
            $this->info("==============================================");
            $this->info("NOMINA COMPLETADA PARA EL DÍA 19 DE " . $fechaProceso->format('M Y'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Error Crítico: " . $e->getMessage());
        }
    }
}
