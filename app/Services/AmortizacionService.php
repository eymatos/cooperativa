<?php

namespace App\Services;

class AmortizacionService
{
    /**
     * Genera la tabla de amortización (Sistema Francés)
     */
    public function calcularCuotas($monto, $tasaAnual, $plazoMeses, $fechaInicio)
    {
        $tabla = [];
        $saldo = $monto;

        // Convertir tasa anual a mensual (Ej: 12% -> 0.12 / 12 = 0.01)
        $tasaMensual = ($tasaAnual / 100) / 12;

        // Fórmula de Cuota Fija (PMT)
        // Cuota = (P * i) / (1 - (1+i)^-n)
        if ($tasaMensual > 0) {
            $cuotaFija = ($monto * $tasaMensual) / (1 - pow(1 + $tasaMensual, -$plazoMeses));
        } else {
            $cuotaFija = $monto / $plazoMeses; // Si la tasa es 0
        }

        $fecha = \Carbon\Carbon::parse($fechaInicio);

        for ($i = 1; $i <= $plazoMeses; $i++) {
            $interes = $saldo * $tasaMensual;
            $capital = $cuotaFija - $interes;
            $saldo -= $capital;

            // Ajuste final por decimales en la última cuota
            if ($i == $plazoMeses && abs($saldo) < 1) {
                $capital += $saldo;
                $saldo = 0;
            }

            $fecha->addMonth(); // Siguiente mes

            $tabla[] = [
                'numero_cuota' => $i,
                'capital' => round($capital, 2),
                'interes' => round($interes, 2),
                'monto_total' => round($capital + $interes, 2),
                'saldo_restante' => round(max(0, $saldo), 2),
                'fecha_vencimiento' => $fecha->format('Y-m-d')
            ];
        }

        return $tabla;
    }
}
