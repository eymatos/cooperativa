<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Pago;
use App\Models\Cuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    // Muestra el formulario para pagar un préstamo específico
    public function create($prestamo_id)
    {
        // 1. Buscamos el préstamo con sus relaciones
        $prestamo = Prestamo::with(['socio.user', 'cuotas'])->findOrFail($prestamo_id);

        // 2. Buscamos la siguiente cuota pendiente (la más vieja sin pagar)
        $siguienteCuota = $prestamo->cuotas()
            ->where('estado', 'pendiente')
            ->orderBy('fecha_vencimiento', 'asc')
            ->first();

        return view('admin.pagos.create', compact('prestamo', 'siguienteCuota'));
    }

    // Procesa y guarda el pago
    public function store(Request $request, $prestamo_id)
    {
        $request->validate([
            'monto' => 'required|numeric|min:1',
            'fecha_pago' => 'required|date'
        ]);

        $prestamo = Prestamo::findOrFail($prestamo_id);

        DB::transaction(function () use ($request, $prestamo) {

            // 1. Registrar el Pago Histórico
            \App\Models\Pago::create([
                'prestamo_id' => $prestamo->id,
                'user_id'     => auth()->id(),
                'monto'       => $request->monto,
                'fecha_pago'  => $request->fecha_pago,
            ]);

            // 2. LÓGICA DE ABONO CORREGIDA
            $dineroDisponible = $request->monto;

            // Buscamos cuotas que no estén totalmente pagadas
            $cuotasPendientes = $prestamo->cuotas()
                ->where('estado', 'pendiente')
                ->orderBy('fecha_vencimiento', 'asc')
                ->get();

            foreach ($cuotasPendientes as $cuota) {
                if ($dineroDisponible <= 0) break;

                // CALCULO CORRECTO:
                // Deuda de la cuota = Total de la cuota - Lo que ya se ha abonado a esa cuota
                $deudaRealCuota = $cuota->monto_total - $cuota->abonado;

                if ($dineroDisponible >= $deudaRealCuota) {
                    // Paga la cuota completa
                    $cuota->abonado += $deudaRealCuota; // Se llena el abono
                    $cuota->estado = 'pagado';          // Se marca pagado
                    $cuota->save();

                    $dineroDisponible -= $deudaRealCuota;
                } else {
                    // Abono parcial (no alcanza para cerrar la cuota)
                    $cuota->abonado += $dineroDisponible;
                    $cuota->save();

                    $dineroDisponible = 0;
                }
            }

            // 3. Actualizar Saldo Global del Préstamo (Capital)
            // Nota: Aquí estamos asumiendo que todo abono reduce capital para simplificar,
            // en un sistema real esto depende de si pagas interés o capital.
            // Para mantener coherencia visual con tu tabla:
            $prestamo->saldo_capital -= $request->monto;

            if ($prestamo->saldo_capital <= 0.5) { // Margen de error por decimales
                 $prestamo->estado = 'pagado';
                 $prestamo->saldo_capital = 0;
            }
            $prestamo->save();
        });

        return redirect()->route('admin.prestamos.show', $prestamo_id)
            ->with('success', 'Pago registrado correctamente.');
    }
}
