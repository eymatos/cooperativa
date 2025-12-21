<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prestamo;
use App\Models\Socio;
use App\Services\AmortizacionService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RepararTablasAmortizacion extends Command
{
    protected $signature = 'prestamos:reparar-tablas';
    protected $description = 'Sanea intereses basándose estrictamente en el primer cobro real de los préstamos sucesores';

    public function handle(AmortizacionService $amortizacion)
    {
        $socios = Socio::all();
        $fechaCierreGestion = Carbon::create(2025, 12, 31);

        $this->info("Iniciando auditoría de cuotas basada en cobros reales...");

        foreach ($socios as $socio) {
            $prestamosSocio = $socio->prestamos()->orderBy('fecha_inicio', 'asc')->get();

            foreach ($prestamosSocio as $p) {
                // BUSQUEDA DEL PUNTO DE CORTE REAL
                // Buscamos el primer abono de CUALQUIER préstamo del socio que haya iniciado después que este
                // y que sea del mismo tipo, para marcar el fin del cobro de intereses del viejo.
                $mesPrimerCobroSucesor = DB::table('cuotas')
                    ->join('prestamos', 'cuotas.prestamo_id', '=', 'prestamos.id')
                    ->where('prestamos.socio_id', $socio->id)
                    ->where('prestamos.tipo_prestamo_id', $p->tipo_prestamo_id)
                    ->where('prestamos.fecha_inicio', '>', $p->fecha_inicio) // Es un préstamo posterior
                    ->where('cuotas.numero_cuota', 1)
                    ->orderBy('prestamos.fecha_inicio', 'asc')
                    ->value('cuotas.fecha_vencimiento');

                $mesCorte = $mesPrimerCobroSucesor ? Carbon::parse($mesPrimerCobroSucesor)->format('Y-m') : null;

                DB::transaction(function () use ($p, $amortizacion, $fechaCierreGestion, $mesCorte) {
                    $p->cuotas()->delete();

                    $tablaCorrecta = $amortizacion->calcularCuotas(
                        $p->monto,
                        $p->tasa_interes,
                        $p->plazo,
                        $p->fecha_inicio
                    );

                    foreach ($tablaCorrecta as $fila) {
                        $vencimiento = Carbon::parse($fila['fecha_vencimiento']);
                        $mesActual = $vencimiento->format('Y-m');

                        if (strtolower($p->estado) === 'pagado') {
                            $fila['estado'] = 'pagado';

                            // Si este mes coincide con el inicio de pago del préstamo nuevo,
                            // el viejo ya no genera intereses.
                            if ($mesCorte && $mesActual >= $mesCorte) {
                                $fila['interes'] = 0;
                                $fila['monto_total'] = $fila['capital'];
                                $fila['pagado'] = $fila['capital'];
                            }

                            $fila['abonado'] = $fila['monto_total'];
                        }
                        else {
                            // Préstamos Activos
                            if ($vencimiento->lte($fechaCierreGestion)) {
                                $fila['estado'] = 'pagado';
                                $fila['abonado'] = $fila['monto_total'];
                            } else {
                                $fila['estado'] = 'pendiente';
                                $fila['abonado'] = 0;
                            }
                        }
                        $p->cuotas()->create($fila);
                    }

                    if (strtolower($p->estado) === 'pagado') {
                        $p->saldo_capital = 0;
                        $p->saveQuietly();
                    }
                });
            }
            $this->line("✅ Historial reconstruido para: {$socio->user->name}");
        }

        $this->info("¡Saneamiento terminado! Se ha respetado la transición real de cada préstamo.");
    }
}
