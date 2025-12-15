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
            'tipo_prestamo_id' => 'required|exists:tipo_prestamos,id', // <--- NUEVA VALIDACIÓN
            'monto' => 'required|numeric|min:100',
            'tasa_interes' => 'required|numeric',
            'plazo' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
        ]);

        // Buscamos al socio
        $socio = \App\Models\Socio::where('user_id', $request->user_id)->firstOrFail();

        DB::transaction(function () use ($request, $socio) {

            // Crear Cabecera
            $prestamo = Prestamo::create([
                'socio_id'         => $socio->id,
                'tipo_prestamo_id' => $request->tipo_prestamo_id, // <--- GUARDAMOS EL TIPO
                'monto'            => $request->monto,
                'tasa_interes'     => $request->tasa_interes,
                'plazo'            => $request->plazo,
                'saldo_capital'    => $request->monto,
                'fecha_solicitud'  => now(),
                'fecha_inicio'     => $request->fecha_inicio,
                'estado'           => 'activo'
            ]);

            // Calcular Tabla
            $tabla = $this->amortizacion->calcularCuotas(
                $request->monto,
                $request->tasa_interes,
                $request->plazo,
                $request->fecha_inicio
            );

            // Guardar Cuotas
            foreach ($tabla as $fila) {
                $prestamo->cuotas()->create($fila);
            }
        });

        return redirect()->route('admin.prestamos.index')
            ->with('success', 'Préstamo creado correctamente');
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
}
