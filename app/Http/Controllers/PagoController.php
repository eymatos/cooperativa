<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Pago;
use App\Models\Cuota;
use App\Services\AmortizacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PagoController extends Controller
{
    protected $amortizacion;

    public function __construct(AmortizacionService $amortizacion)
    {
        $this->amortizacion = $amortizacion;
    }

    public function create($prestamo_id)
    {
        $prestamo = Prestamo::with(['socio.user', 'cuotas'])->findOrFail($prestamo_id);
        $siguienteCuota = $prestamo->cuotas()
            ->whereIn('estado', ['pendiente', 'Pendiente'])
            ->orderBy('fecha_vencimiento', 'asc')
            ->first();

        return view('admin.pagos.create', compact('prestamo', 'siguienteCuota'));
    }

    public function store(Request $request, $prestamo_id)
    {
        $request->validate([
            'monto' => 'required|numeric|min:1',
            'fecha_pago' => 'required|date',
            'tipo_pago' => 'required|in:cascada,capital',
            'opcion_capital' => 'required_if:tipo_pago,capital|in:cuota,plazo'
        ]);

        $prestamo = Prestamo::findOrFail($prestamo_id);

        DB::transaction(function () use ($request, $prestamo) {
            Pago::create([
                'prestamo_id' => $prestamo->id,
                'user_id'     => auth()->id(),
                'monto'       => $request->monto,
                'fecha_pago'  => $request->fecha_pago,
                'nota'        => $request->tipo_pago == 'capital' ? "Abono Directo a Capital" : "Pago Ordinario"
            ]);

            if ($request->tipo_pago === 'cascada') {
                $this->procesarPagoCascada($prestamo, $request->monto);
            } else {
                $this->procesarAbonoCapitalDirecto($prestamo, $request->monto, $request->opcion_capital);
            }

            if ($prestamo->saldo_capital <= 0.5) {
                $prestamo->estado = 'pagado';
                $prestamo->saldo_capital = 0;
            }
            $prestamo->save();
        });

        return redirect()->route('admin.prestamos.show', $prestamo->id)
            ->with('success', 'Abono aplicado y tabla de amortización actualizada correctamente.');
    }

    protected function procesarAbonoCapitalDirecto($prestamo, $monto, $opcion)
    {
        // 1. Reducir capital global
        $prestamo->saldo_capital -= $monto;

        // 2. Identificar la fecha del próximo vencimiento real
        $proximaCuota = $prestamo->cuotas()
            ->whereIn('estado', ['pendiente', 'Pendiente'])
            ->orderBy('fecha_vencimiento', 'asc')
            ->first();

        $fechaReinicio = $proximaCuota ? $proximaCuota->fecha_vencimiento : ($prestamo->fecha_primer_pago ?? now()->addMonth());

        // 3. Obtener el número de la última cuota pagada antes de la limpieza
        // Es importante excluir el 0 para no duplicar abonos en el conteo
        $ultimoNumeroPagado = $prestamo->cuotas()
            ->whereIn('estado', ['pagado', 'Pagado'])
            ->where('numero_cuota', '>', 0)
            ->max('numero_cuota') ?? 0;

        // 4. Borrar cuotas pendientes para regenerar
        $prestamo->cuotas()->whereIn('estado', ['pendiente', 'Pendiente'])->delete();

        if ($prestamo->saldo_capital > 0) {
            if ($opcion === 'cuota') {
                // REDUCIR CUOTA: Mismo plazo restante
                $cuotasYaPagadas = $prestamo->cuotas()
                    ->whereIn('estado', ['pagado', 'Pagado'])
                    ->where('numero_cuota', '>', 0)
                    ->count();
                $plazoRestante = $prestamo->plazo - $cuotasYaPagadas;
                $plazoRestante = $plazoRestante > 0 ? $plazoRestante : 1;

                $nuevaTabla = $this->amortizacion->calcularCuotas(
                    $prestamo->saldo_capital,
                    $prestamo->tasa_interes,
                    $plazoRestante,
                    now(),
                    $fechaReinicio,
                    $monto
                );
            } else {
                // REDUCIR PLAZO: Misma cuota mensual
                $cuotaOriginal = $prestamo->monto / $prestamo->plazo;
                $nuevoPlazo = $this->calcularNuevoPlazo($prestamo->saldo_capital, $prestamo->tasa_interes, $cuotaOriginal);

                $nuevaTabla = $this->amortizacion->calcularCuotas(
                    $prestamo->saldo_capital,
                    $prestamo->tasa_interes,
                    $nuevoPlazo,
                    now(),
                    $fechaReinicio,
                    $monto
                );
            }

            foreach ($nuevaTabla as $fila) {
                // REGLA DE ORO: Si el servicio devuelve numero_cuota 0, se queda en 0.
                // Si es mayor a 0, seguimos la secuencia después de la última pagada.
                if ($fila['numero_cuota'] != 0) {
                    $ultimoNumeroPagado++;
                    $fila['numero_cuota'] = $ultimoNumeroPagado;
                }

                $prestamo->cuotas()->create($fila);
            }
        }
    }

    private function calcularNuevoPlazo($saldo, $tasa, $cuotaDeseada) {
        $i = ($tasa / 100) / 12;
        if ($i == 0) return ceil($saldo / $cuotaDeseada);
        if (($saldo * $i) >= $cuotaDeseada) return 12;
        $n = -log(1 - ($saldo * $i) / $cuotaDeseada) / log(1 + $i);
        return max(1, (int)ceil($n));
    }

    protected function procesarPagoCascada($prestamo, $monto)
    {
        $dinero = $monto;
        $cuotas = $prestamo->cuotas()
            ->whereIn('estado', ['pendiente', 'Pendiente'])
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();

        foreach ($cuotas as $cuota) {
            if ($dinero <= 0) break;
            $deuda = $cuota->monto_total - $cuota->abonado;

            if ($dinero >= $deuda) {
                $cuota->update(['abonado' => $cuota->monto_total, 'estado' => 'pagado']);
                $dinero -= $deuda;
                $prestamo->saldo_capital -= $cuota->capital;
            } else {
                $cuota->increment('abonado', $dinero);
                $ratio = $cuota->capital / ($cuota->monto_total ?: 1);
                $prestamo->saldo_capital -= ($dinero * $ratio);
                $dinero = 0;
            }
        }
    }
}
