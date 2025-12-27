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
            'fecha_primer_pago' => 'required|date', // Se cambia a obligatorio en simulación
        ]);

        $tabla = $this->amortizacion->calcularCuotas(
            $request->monto,
            $request->tasa_interes,
            $request->plazo,
            $request->fecha_inicio,
            $request->fecha_primer_pago
        );

        return response()->json($tabla);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tipo_prestamo_id' => 'required|exists:tipo_prestamos,id',
            'numero_prestamo' => 'required|string|unique:prestamos,numero_prestamo',
            'monto' => 'required|numeric|min:100',
            'tasa_interes' => 'required|numeric',
            'plazo' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
            'fecha_primer_pago' => 'required|date', // Se cambia a OBLIGATORIO aquí
        ]);

        $socio = \App\Models\Socio::where('user_id', $request->user_id)->firstOrFail();

        DB::transaction(function () use ($request, $socio) {
            $prestamo = Prestamo::create([
                'socio_id'         => $socio->id,
                'tipo_prestamo_id' => $request->tipo_prestamo_id,
                'numero_prestamo'  => $request->numero_prestamo,
                'monto'            => $request->monto,
                'tasa_interes'     => $request->tasa_interes,
                'plazo'            => $request->plazo,
                'saldo_capital'    => $request->monto,
                'fecha_solicitud'  => now(),
                'fecha_inicio'     => $request->fecha_inicio,
                'fecha_primer_pago' => $request->fecha_primer_pago,
                'estado'           => 'activo'
            ]);

            $tabla = $this->amortizacion->calcularCuotas(
                $request->monto,
                $request->tasa_interes,
                $request->plazo,
                $request->fecha_inicio,
                $request->fecha_primer_pago
            );

            foreach ($tabla as $fila) {
                $prestamo->cuotas()->create($fila);
            }
        });

        return redirect()->route('admin.socios.show', $socio->id)
            ->with('success', 'Préstamo #' . $request->numero_prestamo . ' creado correctamente.');
    }

    // ... (El resto de métodos permanecen igual)

    public function marcarPagado($id)
    {
        $prestamo = Prestamo::findOrFail($id);

        DB::transaction(function () use ($prestamo) {
            $prestamo->cuotas()->where('estado', 'pendiente')->update([
                'estado' => 'pagado',
                'pagado' => DB::raw('monto_total'),
                'abonado' => DB::raw('monto_total')
            ]);

            $prestamo->update([
                'estado' => 'pagado',
                'saldo_capital' => 0
            ]);
        });

        return back()->with('success', '✅ El préstamo #' . $prestamo->numero_prestamo . ' ha sido marcado como pagado.');
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
            $cuotas = $prestamo->cuotas()
                ->where('estado', 'pendiente')
                ->orderBy('numero_cuota', 'asc')
                ->get();

            if ($cuotas->isEmpty()) return;

            foreach ($cuotas as $cuota) {
                $cuota->update([
                    'interes'     => 0.00,
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
            ->with('success', 'El préstamo ha sido liquidado exitosamente sin cobro de intereses futuros.');
    }

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
            'fecha_primer_pago' => 'required|date', // Se cambia a obligatorio aquí también
        ]);

        $prestamo = Prestamo::findOrFail($id);

        DB::transaction(function () use ($request, $prestamo) {
            $prestamo->update([
                'tipo_prestamo_id' => $request->tipo_prestamo_id,
                'monto'            => $request->monto,
                'tasa_interes'     => $request->tasa_interes,
                'plazo'            => $request->plazo,
                'fecha_inicio'     => $request->fecha_inicio,
                'fecha_primer_pago' => $request->fecha_primer_pago,
                'saldo_capital'    => $request->monto,
            ]);

            $prestamo->cuotas()->delete();

            $tabla = $this->amortizacion->calcularCuotas(
                $request->monto,
                $request->tasa_interes,
                $request->plazo,
                $request->fecha_inicio,
                $request->fecha_primer_pago
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
        $prestamosPorCerrar = Prestamo::with(['socio.user', 'tipoPrestamo'])
            ->where('estado', 'activo')
            ->where('saldo_capital', '<=', 0.5)
            ->get()
            ->groupBy(function($item) {
                return $item->tipoPrestamo->nombre ?? 'Otros';
            });

        $prestamosVenciendo = Prestamo::with(['socio.user', 'tipoPrestamo', 'cuotas'])
            ->where('estado', 'activo')
            ->where('saldo_capital', '>', 0.5)
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

        return view('admin.prestamos.vencimientos', compact('prestamosPorCerrar', 'prestamosVenciendo'));
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
