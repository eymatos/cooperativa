<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use App\Models\Prestamo;
use App\Services\AmortizacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    protected $amortizacion;

    // Inyectamos el servicio automáticamente
    public function __construct(AmortizacionService $amortizacion)
    {
        $this->amortizacion = $amortizacion;
    }

    // Mostrar formulario
    public function create()
    {
        $socios = Socio::all(); // En sistema real usar paginación o buscador
        return view('prestamos.create', compact('socios'));
    }

    // Guardar préstamo y generar cuotas
    public function store(Request $request)
    {
        $request->validate([
            'socio_id' => 'required|exists:socios,id',
            'monto' => 'required|numeric|min:100',
            'tasa_interes' => 'required|numeric',
            'plazo' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
        ]);

        // Usamos transacción para asegurar que se guarde TODO o NADA
        DB::transaction(function () use ($request) {

            // 1. Crear Cabecera del Préstamo
            $prestamo = Prestamo::create([
                'socio_id' => $request->socio_id,
                'monto' => $request->monto,
                'tasa_interes' => $request->tasa_interes,
                'plazo' => $request->plazo,
                'saldo_capital' => $request->monto,
                'fecha_solicitud' => now(),
                'fecha_inicio' => $request->fecha_inicio,
                'estado' => 'activo'
            ]);

            // 2. Calcular Tabla de Amortización (Usando el Service)
            $tabla = $this->amortizacion->calcularCuotas(
                $request->monto,
                $request->tasa_interes,
                $request->plazo,
                $request->fecha_inicio
            );

            // 3. Guardar las Cuotas en la BD
            foreach ($tabla as $fila) {
                $prestamo->cuotas()->create([
                    'numero_cuota' => $fila['numero_cuota'],
                    'capital' => $fila['capital'],
                    'interes' => $fila['interes'],
                    'monto_total' => $fila['monto_total'],
                    'fecha_vencimiento' => $fila['fecha_vencimiento'],
                    'estado' => 'pendiente'
                ]);
            }
        });

        return redirect()->route('prestamos.index')->with('success', 'Préstamo creado correctamente');
    }
    // Listado de préstamos
    public function index()
    {
        $prestamos = Prestamo::with('socio')->latest()->get();
        return view('prestamos.index', compact('prestamos'));
    }

    // Detalle de un préstamo (Tabla de amortización)
    public function show(Prestamo $prestamo)
    {
        // Cargamos las cuotas para mostrarlas
        $prestamo->load('cuotas');
        return view('prestamos.show', compact('prestamo'));
    }
}
