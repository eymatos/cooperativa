<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    // Mostrar el formulario de pago para un préstamo específico
    public function create(Prestamo $prestamo)
    {
        return view('pagos.create', compact('prestamo'));
    }

    // Guardar el pago y aplicarlo a las cuotas (Lógica Crítica)
    public function store(Request $request, Prestamo $prestamo)
    {
        $request->validate([
            'monto' => 'required|numeric|min:1',
            'fecha_pago' => 'required|date',
            'metodo' => 'required|string'
        ]);

        DB::transaction(function () use ($request, $prestamo) {

            // 1. Registrar el ingreso del dinero (La Caja)
            $pago = Pago::create([
                'prestamo_id' => $prestamo->id,
                'user_id' => Auth::id(), // Quién cobró (el cajero)
                'monto' => $request->monto,
                'fecha_pago' => $request->fecha_pago,
                'metodo' => $request->metodo,
                'referencia' => $request->referencia,
                'nota' => $request->nota
            ]);

            // 2. Distribuir el dinero en las cuotas (El Algoritmo)
            $dineroDisponible = $request->monto;

            // Buscamos cuotas que no estén pagadas totalmente, ordenadas por fecha (primero la más vieja)
            $cuotasPendientes = $prestamo->cuotas()
                                ->where('estado', '!=', 'pagada')
                                ->orderBy('numero_cuota', 'asc')
                                ->get();

            foreach ($cuotasPendientes as $cuota) {
                if ($dineroDisponible <= 0) break; // Se acabó el dinero

                // Cuánto le falta a esta cuota para saldarse
                $deudaCuota = $cuota->monto_total - $cuota->pagado;

                if ($dineroDisponible >= $deudaCuota) {
                    // ALCANZA para pagar toda la cuota
                    $cuota->pagado += $deudaCuota;
                    $cuota->estado = 'pagada';
                    $dineroDisponible -= $deudaCuota;

                    // Actualizamos saldo capital del préstamo (Restamos el capital de esta cuota)
                    $prestamo->decrement('saldo_capital', $cuota->capital);
                } else {
                    // NO ALCANZA (Abono parcial)
                    $cuota->pagado += $dineroDisponible;
                    $cuota->estado = 'parcial';
                    $dineroDisponible = 0;

                    // Nota: En abono parcial simple, no bajamos saldo capital hasta cubrir interés.
                    // Para simplificar tu portafolio, asumimos pago general por ahora.
                }
                $cuota->save();
            }

            // 3. Verificar si el préstamo se saldó por completo
            $cuotasRestantes = $prestamo->cuotas()->where('estado', '!=', 'pagada')->count();
            if ($cuotasRestantes == 0) {
                $prestamo->update(['estado' => 'pagado']);
            }
        });

        return redirect()->route('prestamos.show', $prestamo)
                         ->with('success', 'Pago registrado correctamente');
    }
}
