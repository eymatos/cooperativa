<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prestamo;
use App\Models\TipoPrestamo;
use App\Services\AmortizacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PrestamoController extends Controller
{
    protected $amortizacion;

    public function __construct(AmortizacionService $amortizacion)
    {
        $this->amortizacion = $amortizacion;
    }

    // --- MÉTODOS DE ADMINISTRADOR ---

    public function index(Request $request)
    {
        $buscar = $request->get('buscar');
        $query = Prestamo::with('socio.user');

        if ($buscar) {
            $query->whereHas('socio.user', function($q) use ($buscar) {
                $q->where('name', 'LIKE', "%$buscar%")
                  ->orWhere('cedula', 'LIKE', "%$buscar%");
            });
        }

        $prestamos = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.prestamos.index', compact('prestamos'));
    }

    public function create(Request $request)
    {
        $socios = User::where('tipo', 0)->get();
        $tiposPrestamo = TipoPrestamo::all();
        $socioPreseleccionado = $request->query('user_id');

        return view('admin.prestamos.create', compact('socios', 'socioPreseleccionado', 'tiposPrestamo'));
    }

    public function simular(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric|min:100',
            'tasa_interes' => 'required|numeric',
            'plazo' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
        ]);

        $tabla = $this->amortizacion->calcularCuotas(
            $request->monto,
            $request->tasa_interes,
            $request->plazo,
            $request->fecha_inicio
        );

        return response()->json($tabla);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tipo_prestamo_id' => 'required|exists:tipo_prestamos,id',
            'monto' => 'required|numeric|min:100',
            'tasa_interes' => 'required|numeric',
            'plazo' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
        ]);

        $socio = \App\Models\Socio::where('user_id', $request->user_id)->firstOrFail();

        DB::transaction(function () use ($request, $socio) {
            $anioInicio = \Carbon\Carbon::parse($request->fecha_inicio)->year;
            $ultimoPrestamo = Prestamo::where('numero_prestamo', 'LIKE', "$anioInicio-%")
                                    ->orderBy('id', 'desc')
                                    ->first();

            if ($ultimoPrestamo) {
                $partes = explode('-', $ultimoPrestamo->numero_prestamo);
                $secuencia = intval(end($partes)) + 1;
            } else {
                $secuencia = 1;
            }

            $codigoGenerado = $anioInicio . '-' . str_pad($secuencia, 3, '0', STR_PAD_LEFT);

            $prestamo = Prestamo::create([
                'socio_id'         => $socio->id,
                'tipo_prestamo_id' => $request->tipo_prestamo_id,
                'numero_prestamo'  => $codigoGenerado,
                'monto'            => $request->monto,
                'tasa_interes'     => $request->tasa_interes,
                'plazo'            => $request->plazo,
                'saldo_capital'    => $request->monto,
                'fecha_solicitud'  => now(),
                'fecha_inicio'     => $request->fecha_inicio,
                'estado'           => 'activo'
            ]);

            $tabla = $this->amortizacion->calcularCuotas(
                $request->monto,
                $request->tasa_interes,
                $request->plazo,
                $request->fecha_inicio
            );

            foreach ($tabla as $fila) {
                $prestamo->cuotas()->create($fila);
            }
        });

        return redirect()->route('admin.socios.show', $socio->id)
            ->with('success', 'Préstamo creado correctamente.');
    }

    public function confirmarLiquidacion($id)
    {
        $prestamo = Prestamo::with(['socio.user', 'tipoPrestamo'])->findOrFail($id);
        $datosLiquidacion = $this->amortizacion->calcularLiquidacion($prestamo);

        return view('admin.prestamos.liquidar_confirm', compact('prestamo', 'datosLiquidacion'));
    }

    public function procesarLiquidacion(Request $request, $id)
    {
        $prestamo = Prestamo::findOrFail($id);

        DB::transaction(function () use ($prestamo) {
            $cuotas = $prestamo->cuotas()->where('estado', 'pendiente')->orderBy('numero_cuota', 'asc')->get();

            if ($cuotas->isEmpty()) return;

            $cuotaActual = $cuotas->shift();
            $cuotaActual->update([
                'estado' => 'pagado',
                'pagado' => $cuotaActual->monto_total,
                'abonado' => $cuotaActual->monto_total,
            ]);

            foreach ($cuotas as $cuota) {
                $cuota->update([
                    'interes'     => 0,
                    'monto_total' => $cuota->capital,
                    'pagado'      => $cuota->capital,
                    'abonado'     => $cuota->capital,
                    'estado'      => 'pagado'
                ]);
            }

            $prestamo->update([
                'estado'        => 'pagado',
                'saldo_capital' => 0
            ]);
        });

        return redirect()->route('admin.prestamos.show', $prestamo->id)
            ->with('success', 'El préstamo ha sido liquidado exitosamente.');
    }

    // --- MÉTODOS DE SOCIO Y DETALLES ---

    public function misPrestamos()
    {
        $socio = Auth::user()->socio;
        $prestamos = $socio ? $socio->prestamos()->with('tipoPrestamo')->latest()->get() : collect();

        return view('socio.prestamos.index', compact('prestamos'));
    }

    public function show($id)
    {
        $prestamo = Prestamo::with(['socio.user', 'cuotas', 'tipoPrestamo'])->findOrFail($id);

        if (Auth::user()->tipo == 0) {
            if ($prestamo->socio_id !== Auth::user()->socio->id) {
                abort(403, 'No tienes permiso para ver este préstamo.');
            }
            return view('socio.prestamos.show', compact('prestamo'));
        }

        // Inicializar datos para evitar el Error 500 en la vista
        $datosLiquidacion = [
            'total_a_pagar' => 0,
            'capital_pendiente' => 0,
            'interes_vigente' => 0,
            'cuotas_count' => 0
        ];

        if ($prestamo->estado == 'activo') {
            $datosLiquidacion = $this->amortizacion->calcularLiquidacion($prestamo);
        }

        return view('admin.prestamos.show', compact('prestamo', 'datosLiquidacion'));
    }

    public function edit($id)
    {
        $prestamo = Prestamo::with('socio.user')->findOrFail($id);
        $tiposPrestamo = TipoPrestamo::all();
        return view('admin.prestamos.edit', compact('prestamo', 'tiposPrestamo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_prestamo_id' => 'required|exists:tipo_prestamos,id',
            'monto' => 'required|numeric|min:100',
            'tasa_interes' => 'required|numeric',
            'plazo' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
        ]);

        $prestamo = Prestamo::findOrFail($id);

        DB::transaction(function () use ($request, $prestamo) {
            $prestamo->update([
                'tipo_prestamo_id' => $request->tipo_prestamo_id,
                'monto'            => $request->monto,
                'tasa_interes'     => $request->tasa_interes,
                'plazo'            => $request->plazo,
                'fecha_inicio'     => $request->fecha_inicio,
                'saldo_capital'    => $request->monto,
            ]);

            $prestamo->cuotas()->delete();

            $tabla = $this->amortizacion->calcularCuotas(
                $request->monto,
                $request->tasa_interes,
                $request->plazo,
                $request->fecha_inicio
            );

            foreach ($tabla as $fila) {
                $prestamo->cuotas()->create($fila);
            }
        });

        return redirect()->route('admin.socios.show', $prestamo->socio_id)
            ->with('success', 'Préstamo actualizado correctamente.');
    }

    public function reporteVencimientos()
    {
        $prestamosVenciendo = Prestamo::with(['socio.user', 'tipoPrestamo', 'cuotas'])
            ->where('estado', 'activo')
            ->get()
            ->filter(function($prestamo) {
                $ultimaCuota = $prestamo->cuotas->last();
                if (!$ultimaCuota) return false;
                $fechaVencimiento = \Carbon\Carbon::parse($ultimaCuota->fecha_vencimiento);
                return $fechaVencimiento->isBetween(now(), now()->addDays(45));
            })
            ->groupBy(function($item) {
                return $item->tipoPrestamo->nombre ?? 'Otros';
            });

        return view('admin.prestamos.vencimientos', compact('prestamosVenciendo'));
    }

    public function reporteMorosidad()
    {
        $cuotasVencidas = \App\Models\Cuota::with(['prestamo.socio.user'])
            ->where('estado', 'pendiente')
            ->where('fecha_vencimiento', '<', now())
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();

        return view('admin.prestamos.morosidad', compact('cuotasVencidas'));
    }

    public function calculadoraSocio()
    {
        return view('socio.calculadora');
    }
}
