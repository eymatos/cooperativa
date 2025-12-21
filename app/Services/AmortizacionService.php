<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Prestamo;

class AmortizacionService
{
    /**
     * Genera la tabla de amortización (Sistema Francés)
     * Optimizada para precisión contable absoluta y evitar residuos de redondeo.
     */
    public function calcularCuotas($monto, $tasaAnual, $plazoMeses, $fechaInicio)
    {
        $tabla = [];
        $saldo = (float) $monto;

        // 1. Convertir tasa anual a mensual decimal (sin redondear para mantener precisión)
        $tasaMensual = ($tasaAnual / 100) / 12;

        // 2. Calcular Cuota Fija (Fórmula de Anualidad)
        if ($tasaMensual > 0) {
            $cuotaTeorica = ($monto * $tasaMensual) / (1 - pow(1 + $tasaMensual, -$plazoMeses));
        } else {
            $cuotaTeorica = $monto / $plazoMeses;
        }

        $fecha = Carbon::parse($fechaInicio);

        for ($i = 1; $i <= $plazoMeses; $i++) {
            $interes = round($saldo * $tasaMensual, 2);
            $capital = $cuotaTeorica - $interes;

            if ($i == $plazoMeses) {
                $capital = $saldo;
                $totalCuota = $capital + $interes;
            } else {
                $totalCuota = $cuotaTeorica;
            }

            $saldoActualizado = $saldo - $capital;
            $fechaVencimiento = $fecha->copy()->addMonths($i);

            $tabla[] = [
                'numero_cuota'      => $i,
                'capital'           => round($capital, 2),
                'interes'           => round($interes, 2),
                'monto_total'       => round($totalCuota, 2),
                'pagado'            => round($totalCuota, 2),
                'saldo_restante'    => round(max($saldoActualizado, 0), 2),
                'fecha_vencimiento' => $fechaVencimiento->format('Y-m-d'),
                'estado'            => 'pendiente',
                'abonado'           => 0
            ];

            $saldo = $saldoActualizado;
        }

        return $tabla;
    }

    /**
     * Calcula el monto necesario para liquidar un préstamo hoy.
     * Retorna el capital pendiente total más el interés de la cuota vigente.
     */
    public function calcularLiquidacion(Prestamo $prestamo)
    {
        $cuotasPendientes = $prestamo->cuotas()->where('estado', 'pendiente')->orderBy('numero_cuota', 'asc')->get();

        if ($cuotasPendientes->isEmpty()) {
            return [
                'total_a_pagar' => 0,
                'capital_pendiente' => 0,
                'interes_vigente' => 0,
                'cuotas_a_liquidar' => 0
            ];
        }

        $capitalTotal = $cuotasPendientes->sum('capital');

        // Tomamos el interés de la primera cuota pendiente (la del mes actual)
        // Las cuotas futuras no pagarán interés.
        $interesVigente = $cuotasPendientes->first()->interes;

        return [
            'total_a_pagar'     => round($capitalTotal + $interesVigente, 2),
            'capital_pendiente' => round($capitalTotal, 2),
            'interes_vigente'   => round($interesVigente, 2),
            'cuotas_count'      => $cuotasPendientes->count()
        ];
    }
}
