<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Prestamo;

class AmortizacionService
{
    /**
     * Genera la tabla de amortización (Sistema Francés)
     * @param float $monto Capital actual a amortizar
     * @param float $tasaAnual Tasa de interés
     * @param int $plazoMeses Cantidad de cuotas a generar
     * @param string $fechaInicio Fecha de la transacción
     * @param string|null $fechaPrimerPago Fecha programada para la siguiente cuota
     * @param float $abonoExtraordinario Monto del abono directo a capital
     */
    public function calcularCuotas($monto, $tasaAnual, $plazoMeses, $fechaInicio, $fechaPrimerPago = null, $abonoExtraordinario = 0)
    {
        $tabla = [];
        $saldo = (float) $monto;
        $tasaMensual = ($tasaAnual / 100) / 12;

        // 1. Registro visual del abono (Cuota 0) para que el historial cuadre
        if ($abonoExtraordinario > 0) {
            // El saldo_restante aquí debe ser el saldo después de restar el abono
            $tabla[] = [
                'numero_cuota'      => 0, // Indicador de abono extraordinario
                'capital'           => round($abonoExtraordinario, 2),
                'interes'           => 0.00,
                'monto_total'       => round($abonoExtraordinario, 2),
                'pagado'            => round($abonoExtraordinario, 2),
                'saldo_restante'    => round($saldo, 2),
                'fecha_vencimiento' => Carbon::parse($fechaInicio)->format('Y-m-d'),
                'estado'            => 'pagado',
                'abonado'           => round($abonoExtraordinario, 2),
                'descripcion'       => 'ABONO EXTRAORDINARIO A CAPITAL'
            ];
        }

        // 2. Calcular Cuota Fija (Anualidad)
        if ($tasaMensual > 0) {
            $cuotaTeorica = ($saldo * $tasaMensual) / (1 - pow(1 + $tasaMensual, -$plazoMeses));
        } else {
            $cuotaTeorica = $saldo / $plazoMeses;
        }

        // 3. Determinar la fecha base: Prioriza la columna de primer pago
        $baseFecha = $fechaPrimerPago ? Carbon::parse($fechaPrimerPago) : Carbon::parse($fechaInicio)->addMonth();

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

            // Mantenemos el mismo día del mes definido en la baseFecha
            $fechaVencimiento = $baseFecha->copy()->addMonths($i - 1);

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

    public function calcularLiquidacion(Prestamo $prestamo)
    {
        $cuotasPendientes = $prestamo->cuotas()->where('estado', 'pendiente')->orderBy('numero_cuota', 'asc')->get();

        if ($cuotasPendientes->isEmpty()) {
            return [
                'total_a_pagar' => 0,
                'capital_pendiente' => 0,
                'interes_vigente' => 0,
                'cuotas_count' => 0
            ];
        }

        $capitalTotal = $cuotasPendientes->sum('capital');
        return [
            'total_a_pagar'     => round($capitalTotal, 2),
            'capital_pendiente' => round($capitalTotal, 2),
            'interes_vigente'   => 0,
            'cuotas_count'      => $cuotasPendientes->count()
        ];
    }
}
