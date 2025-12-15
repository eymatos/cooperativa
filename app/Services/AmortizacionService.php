<?php

namespace App\Services;

use Carbon\Carbon;

class AmortizacionService
{
    /**
     * Genera la tabla de amortización (Sistema Francés)
     */
    public function calcularCuotas($monto, $tasaAnual, $plazoMeses, $fechaInicio)
    {
        $tabla = [];
        $saldo = (float) $monto;

        // 1. Convertir tasa anual a mensual
        $tasaMensual = ($tasaAnual / 100) / 12;

        // 2. Calcular Cuota Fija Teórica
        if ($tasaMensual > 0) {
            // Fórmula: P * i / (1 - (1+i)^-n)
            $cuotaTeorica = ($monto * $tasaMensual) / (1 - pow(1 + $tasaMensual, -$plazoMeses));
        } else {
            $cuotaTeorica = $monto / $plazoMeses;
        }

        // Redondeamos la cuota a 2 decimales para que sea "pagable" en moneda real
        $cuotaFija = round($cuotaTeorica, 2);

        $fecha = Carbon::parse($fechaInicio);

        for ($i = 1; $i <= $plazoMeses; $i++) {

            // A. Interés del periodo (redondeado a 2 decimales)
            $interes = round($saldo * $tasaMensual, 2);

            // B. Capital (lo que sobra de la cuota va a capital)
            $capital = $cuotaFija - $interes;

            // C. Manejo especial para la ÚLTIMA cuota
            // Forzamos que el capital sea exactamente lo que queda de saldo
            if ($i == $plazoMeses) {
                $capital = $saldo;
                // Recalculamos la cuota final para que cuadre (puede variar unos centavos)
                $montoTotal = $capital + $interes;
            } else {
                $montoTotal = $cuotaFija;
            }

            // D. Actualizar saldo
            $saldo -= $capital;

            // Evitar -0.00 por errores de flotante en PHP
            if ($saldo < 0) $saldo = 0;

            $fecha->addMonth(); // Siguiente mes

            $tabla[] = [
                'numero_cuota'      => $i,
                'capital'           => number_format($capital, 2, '.', ''), // Formato string para API/JSON
                'interes'           => number_format($interes, 2, '.', ''),
                'monto_total'       => number_format($montoTotal, 2, '.', ''),
                'saldo_restante'    => number_format($saldo, 2, '.', ''),
                'fecha_vencimiento' => $fecha->format('Y-m-d')
            ];
        }

        return $tabla;
    }
}
