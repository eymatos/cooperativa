<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prestamo;
use App\Models\TipoPrestamo; // <--- Importamos el modelo
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
        // Tu lógica de búsqueda y paginación (asumo que la tienes del paso anterior, la dejo básica por ahora si no)
        $query = Prestamo::with('socio.user');

        if ($request->has('buscar') && $request->buscar != '') {
             // ... tu lógica de busqueda ...
        }

        $prestamos = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.prestamos.index', compact('prestamos'));
    }

    public function create(Request $request)
    {
        // 1. Lista de Socios
        $socios = User::where('tipo', 0)->get();

        // 2. NUEVO: Cargamos los Tipos de Préstamo
        $tiposPrestamo = TipoPrestamo::all();

        // 3. Verificamos si hay preselección desde el perfil
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

            // 1. LÓGICA PARA GENERAR EL NÚMERO DE PRÉSTAMO (YYYY-###)

            // A. Obtenemos el año de inicio (Ej: 2026)
            $anioInicio = \Carbon\Carbon::parse($request->fecha_inicio)->year;

            // B. Buscamos el último préstamo registrado QUE TENGA ESE MISMO AÑO en su código
            // Buscamos algo que empiece con "2026-"
            $ultimoPrestamo = Prestamo::where('numero_prestamo', 'LIKE', "$anioInicio-%")
                                    ->orderBy('id', 'desc')
                                    ->first();

            // C. Determinamos la secuencia
            if ($ultimoPrestamo) {
                // Si existe "2026-005", extraemos el "005", lo convertimos a número (5) y sumamos 1
                $partes = explode('-', $ultimoPrestamo->numero_prestamo);
                $secuencia = intval(end($partes)) + 1;
            } else {
                // Si es el primero del año
                $secuencia = 1;
            }

            // D. Formateamos: Año + Guion + Numero rellenado con ceros a la izquierda (Ej: 2026-001)
            $codigoGenerado = $anioInicio . '-' . str_pad($secuencia, 3, '0', STR_PAD_LEFT);


            // 2. CREAMOS EL PRÉSTAMO
            $prestamo = Prestamo::create([
                'socio_id'         => $socio->id,
                'tipo_prestamo_id' => $request->tipo_prestamo_id,
                'numero_prestamo'  => $codigoGenerado, // <--- GUARDAMOS EL CÓDIGO
                'monto'            => $request->monto,
                'tasa_interes'     => $request->tasa_interes,
                'plazo'            => $request->plazo,
                'saldo_capital'    => $request->monto,
                'fecha_solicitud'  => now(),
                'fecha_inicio'     => $request->fecha_inicio,
                'estado'           => 'activo'
            ]);

            // 3. CALCULAR Y GUARDAR CUOTAS
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

    // --- MÉTODOS DE SOCIO Y DETALLES ---

    public function misPrestamos()
    {
        $prestamos = Auth::user()->prestamos()->latest()->get();
        return view('socio.prestamos.index', compact('prestamos'));
    }

    public function show($id)
    {
        $prestamo = Prestamo::with(['socio.user', 'cuotas', 'tipoPrestamo'])->findOrFail($id);
        return view('admin.prestamos.show', compact('prestamo'));
    }
    // --- EDICIÓN DE PRÉSTAMOS ---

    public function edit($id)
    {
        // Cargamos el préstamo y sus relaciones
        $prestamo = Prestamo::with('socio.user')->findOrFail($id);
        $tiposPrestamo = TipoPrestamo::all();

        return view('admin.prestamos.edit', compact('prestamo', 'tiposPrestamo'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validamos igual que en el store
        $request->validate([
            'tipo_prestamo_id' => 'required|exists:tipo_prestamos,id',
            'monto' => 'required|numeric|min:100',
            'tasa_interes' => 'required|numeric',
            'plazo' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
        ]);

        $prestamo = Prestamo::findOrFail($id);

        // 2. Transacción para asegurar integridad (Borrar y Crear)
        DB::transaction(function () use ($request, $prestamo) {

            // A. Actualizamos la Cabecera
            $prestamo->update([
                'tipo_prestamo_id' => $request->tipo_prestamo_id,
                'monto'            => $request->monto,
                'tasa_interes'     => $request->tasa_interes,
                'plazo'            => $request->plazo,
                'fecha_inicio'     => $request->fecha_inicio,
                // OJO: Al editar, reseteamos el saldo al nuevo monto (asumiendo re-estructuración)
                // Si solo quieres corregir un error de dedo y ya pagaron cuotas, la lógica sería más compleja.
                // Aquí asumimos que es una CORRECCIÓN de un préstamo mal creado.
                'saldo_capital'    => $request->monto,
            ]);

            // B. ELIMINAMOS LAS CUOTAS VIEJAS (Porque el cálculo cambió)
            $prestamo->cuotas()->delete();

            // C. RECALCULAMOS LA TABLA NUEVA
            $tabla = $this->amortizacion->calcularCuotas(
                $request->monto,
                $request->tasa_interes,
                $request->plazo,
                $request->fecha_inicio
            );

            // D. GUARDAMOS LAS NUEVAS CUOTAS
            foreach ($tabla as $fila) {
                $prestamo->cuotas()->create($fila);
            }
        });

        return redirect()->route('admin.socios.show', $prestamo->socio_id)
            ->with('success', 'Préstamo actualizado y tabla regenerada correctamente.');
    }
    public function reporteVencimientos()
{
    // Buscamos préstamos activos
    $prestamosVenciendo = Prestamo::with(['socio.user', 'tipoPrestamo', 'cuotas'])
        ->where('estado', 'activo')
        ->get()
        ->filter(function($prestamo) {
            // Obtenemos la fecha de la última cuota
            $ultimaCuota = $prestamo->cuotas->last();
            if (!$ultimaCuota) return false;

            // Filtramos los que vencen en los próximos 45 días
            $fechaVencimiento = \Carbon\Carbon::parse($ultimaCuota->fecha_vencimiento);
            return $fechaVencimiento->isBetween(now(), now()->addDays(45));
        })
        ->groupBy(function($item) {
            // Agrupamos por el nombre del tipo de préstamo
            return $item->tipoPrestamo->nombre ?? 'Otros';
        });

    return view('admin.prestamos.vencimientos', compact('prestamosVenciendo'));
}
public function reporteMorosidad()
{
    // Buscamos cuotas vencidas no pagadas con su socio y préstamo
    $cuotasVencidas = \App\Models\Cuota::with(['prestamo.socio.user'])
        ->where('estado', 'pendiente')
        ->where('fecha_vencimiento', '<', now())
        ->orderBy('fecha_vencimiento', 'asc')
        ->get();

    return view('admin.prestamos.morosidad', compact('cuotasVencidas'));
}
}
