<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;
use App\Models\SavingType;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SocioController extends Controller
{
    // 1. LISTA DE SOCIOS (Buscador Inteligente Normalizado)
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');

        $socios = \App\Models\User::where('tipo', 0)
            // 'socio.cuentas' carga las cuentas de ahorro para no hacer 100 consultas a la vez (Eager Loading)
            // Por esto (Carga anidada):
            ->with(['socio.cuentas.type'])
            ->when($buscar, function ($query) use ($buscar) {
                return $query->where(function ($q) use ($buscar) {
                    $q->where('cedula', 'LIKE', "%$buscar%")
                      ->orWhere('name', 'LIKE', "%$buscar%")
                      ->orWhereHas('socio', function ($sq) use ($buscar) {
                          $sq->where('nombres', 'LIKE', "%$buscar%")
                             ->orWhere('apellidos', 'LIKE', "%$buscar%");
                      });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $socios->appends(['buscar' => $buscar]);

        return view('admin.socios.index', compact('socios'));
    }
    // --- NUEVOS MÉTODOS PARA CREACIÓN ---

    /**
     * Muestra el formulario para crear un nuevo socio.
     */
    public function create()
    {
        return view('admin.socios.create');
    }

    /**
     * Procesa el registro del Usuario y del Socio simultáneamente.
     */
    public function store(Request $request)
    {
        // 1. VALIDACIÓN: Aseguramos que los datos sean correctos antes de tocar la BD.
        $request->validate([
            'cedula'    => 'required|unique:users,cedula', // No permite cédulas duplicadas
            'nombres'   => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email', // No permite correos duplicados
            'password'  => 'required|min:6', // Contraseña mínima de 6 caracteres
            'sueldo'    => 'required|numeric',
        ]);

        try {
            // 2. TRANSACCIÓN: Si falla la creación del socio, se "deshace" la del usuario.
            return DB::transaction(function () use ($request) {

                // 3. CREAR EL USUARIO (Credenciales de acceso)
                $user = User::create([
                    'name'     => $request->nombres . ' ' . $request->apellidos,
                    'email'    => $request->email,
                    'cedula'   => $request->cedula,
                    'password' => Hash::make($request->password), // Encriptación obligatoria
                    'tipo'     => 0, // Definimos que es tipo Socio (0)
                ]);

                // 4. CREAR EL SOCIO (Perfil detallado vinculado al usuario)
                $user->socio()->create([
                    'nombres'       => $request->nombres,
                    'apellidos'     => $request->apellidos,
                    'telefono'      => $request->telefono,
                    'direccion'     => $request->direccion,
                    'sueldo'        => $request->sueldo,
                    'lugar_trabajo' => $request->lugar_trabajo,
                    'ahorro_total'  => 0, // Inicia en cero
                ]);

                return redirect()->route('admin.socios.index')
                    ->with('success', 'Socio y Usuario creados exitosamente.');
            });

        } catch (\Exception $e) {
            // Si algo sale mal, volvemos atrás con el error para corregir.
            return back()->with('error', 'Error al registrar: ' . $e->getMessage())->withInput();
        }
    }

    // 2. PERFIL 360 DEL SOCIO
    public function show(Request $request, $id)
    {
        // 1. CARGAR DATOS
        $socio = \App\Models\Socio::with('user')->findOrFail($id);

        // --- LÓGICA DE PRÉSTAMOS ---
        // Préstamos Activos (NO pagados)
        $prestamosActivos = $socio->prestamos()->where('estado', '!=', 'pagado')->get();
        // Préstamos Inactivos (Pagados) - Usados para el contador del botón de historial
        $prestamosInactivos = $socio->prestamos()->where('estado', 'pagado')->get();
        $totalDeuda = $prestamosActivos->sum('saldo_capital');

        // --- LÓGICA DE AHORROS ---
        $tipoAportacion = \App\Models\SavingType::where('code', 'aportacion')->first();
        $tipoVoluntario = \App\Models\SavingType::where('code', 'voluntario')->first();

        if (!$tipoAportacion || !$tipoVoluntario) {
            return back()->with('error', 'Faltan configurar los tipos de ahorro.');
        }

        $cuentaAportacion = \App\Models\SavingsAccount::firstOrCreate(
            ['socio_id' => $socio->id, 'saving_type_id' => $tipoAportacion->id],
            ['balance' => 0, 'recurring_amount' => 0]
        );

        $cuentaVoluntario = \App\Models\SavingsAccount::firstOrCreate(
            ['socio_id' => $socio->id, 'saving_type_id' => $tipoVoluntario->id],
            ['balance' => 0, 'recurring_amount' => 0]
        );

        // 4. PREPARAR EL FILTRO DE AÑOS
        $cuentasIds = [$cuentaAportacion->id, $cuentaVoluntario->id];

        // Obtenemos años con datos de la BD
        $aniosBD = \App\Models\SavingsTransaction::whereIn('savings_account_id', $cuentasIds)
            ->selectRaw('YEAR(date) as anio')
            ->distinct()
            ->pluck('anio')
            ->toArray();

        // Forzamos que siempre aparezca el año actual y el próximo (para registro futuro)
        $aniosDisponibles = array_unique(array_merge($aniosBD, [(int)date('Y'), (int)date('Y') + 1]));
        rsort($aniosDisponibles);

        // Capturamos el año seleccionado o el año actual por defecto
        $anioSeleccionado = $request->get('anio_ahorro', (string)date('Y'));


        // 5. FUNCIÓN MAESTRA MEJORADA (Ahora guarda los objetos completos para editar)
        $armarMatrizMensual = function($cuenta) use ($anioSeleccionado) {
            $meses = [];
            for ($i = 1; $i <= 12; $i++) {
                $meses[$i] = [
                    'aporte' => 0,
                    'retiro' => 0,
                    'transacciones' => [] // Aquí guardaremos los detalles
                ];
            }

            $transaccionesQuery = $cuenta->transactions();
            if ($anioSeleccionado != 'todos') {
                $transaccionesQuery->whereYear('date', $anioSeleccionado);
            }

            $transacciones = $transaccionesQuery->orderBy('date', 'asc')->get();

            foreach ($transacciones as $tx) {

                if ($anioSeleccionado != 'todos' && $tx->date->year != $anioSeleccionado) {
                    continue;
                }

                $mes = $tx->date->month;

                // Sumar totales
                if ($tx->type == 'deposit' || $tx->type == 'interest') {
                    $meses[$mes]['aporte'] += $tx->amount;
                } elseif ($tx->type == 'withdrawal') {
                    $meses[$mes]['retiro'] += $tx->amount;
                }

                // Guardar la transacción completa en el array del mes
                $meses[$mes]['transacciones'][] = $tx;
            }
            return $meses;
        };

        // 6. EJECUTAR LÓGICA
        $matrizAportacion = $armarMatrizMensual($cuentaAportacion);
        $matrizVoluntario = $armarMatrizMensual($cuentaVoluntario);

        // 7. TOTALES GENERALES
        $totalAportaciones = $cuentaAportacion->balance;
        $totalRetirable = $cuentaVoluntario->balance;
        $totalAhorradoGlobal = $totalAportaciones + $totalRetirable;

        // 8. ENVIAR A LA VISTA
        return view('admin.socios.show', compact(
            'socio', 'totalDeuda', 'prestamosActivos', 'prestamosInactivos',
            'aniosDisponibles', 'anioSeleccionado',
            'matrizAportacion', 'matrizVoluntario',
            'cuentaAportacion', 'cuentaVoluntario',
            'totalAportaciones', 'totalRetirable', 'totalAhorradoGlobal'
        ));
    }

    // 3. NUEVO MÉTODO: Muestra la lista de préstamos Pagados
    public function showHistorialPrestamos(Socio $socio)
    {
        // Carga los préstamos cuyo estado es 'pagado'
        $prestamosPagados = $socio->prestamos()
                                  ->where('estado', 'pagado')
                                  ->orderBy('fecha_inicio', 'desc')
                                  ->get();

        return view('admin.socios.historial_prestamos', compact('socio', 'prestamosPagados'));
    }

    // --- MÉTODOS PARA GESTIÓN DE TRANSACCIONES ---

    // 1. Guardar una NUEVA transacción manual (Corrección o Agregado)
    public function storeTransaction(Request $request)
    {
        $request->validate([
            'savings_account_id' => 'required|exists:savings_accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:deposit,withdrawal',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255'
        ]);

        $cuenta = \App\Models\SavingsAccount::findOrFail($request->savings_account_id);

        $tx = $cuenta->transactions()->create([
            'type' => $request->type,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description ?? 'Corrección manual'
        ]);

        if($request->type == 'deposit') {
            $cuenta->balance += $request->amount;
        } else {
            $cuenta->balance -= $request->amount;
        }
        $cuenta->save();

        // REDIRECCIÓN INTELIGENTE
        $anioRedireccion = Carbon::parse($tx->date)->year;
        $socioId = $cuenta->socio_id;

        return redirect()->route('admin.socios.show', [
            'socio' => $socioId,
            'anio_ahorro' => $anioRedireccion
        ])->with('success', 'Transacción agregada correctamente. Mostrando año ' . $anioRedireccion);
    }

    // 2. Actualizar una transacción existente
    public function updateTransaction(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255'
        ]);

        $tx = \App\Models\SavingsTransaction::findOrFail($id);
        $cuenta = $tx->account;

        $socioId = $cuenta->socio_id;

        if ($tx->type == 'deposit' || $tx->type == 'interest') {
            $cuenta->balance -= $tx->amount;
        } else {
            $cuenta->balance += $tx->amount;
        }

        $tx->amount = $request->amount;
        $tx->date = $request->date;
        $tx->description = $request->description;
        $tx->save();

        if ($tx->type == 'deposit' || $tx->type == 'interest') {
            $cuenta->balance += $tx->amount;
        } else {
            $cuenta->balance -= $tx->amount;
        }
        $cuenta->save();

        // REDIRECCIÓN INTELIGENTE
        $anioRedireccion = Carbon::parse($request->date)->year;

        return redirect()->route('admin.socios.show', [
            'socio' => $socioId,
            'anio_ahorro' => $anioRedireccion
        ])->with('success', 'Transacción actualizada correctamente. Mostrando año ' . $anioRedireccion);
    }

    // 3. Eliminar transacción
    public function destroyTransaction($id)
    {
        $tx = \App\Models\SavingsTransaction::findOrFail($id);
        $cuenta = $tx->account;

        $socioId = $cuenta->socio_id;
        $anioRedireccion = Carbon::parse($tx->date)->year;

        if ($tx->type == 'deposit' || $tx->type == 'interest') {
            $cuenta->balance -= $tx->amount;
        } else {
            $cuenta->balance += $tx->amount;
        }
        $cuenta->save();

        $tx->delete();

        // REDIRECCIÓN INTELIGENTE
        return redirect()->route('admin.socios.show', [
            'socio' => $socioId,
            'anio_ahorro' => $anioRedireccion
        ])->with('success', 'Transacción eliminada. Volviendo al año ' . $anioRedireccion);
    }

    public function updateCuota(Request $request, $id)
    {
        $request->validate([
            'recurring_amount' => 'required|numeric|min:0'
        ]);

        $cuenta = \App\Models\SavingsAccount::findOrFail($id);
        $cuenta->recurring_amount = $request->recurring_amount;
        $cuenta->save();

        return back()->with('success', 'Cuota mensual actualizada correctamente.');
    }
    public function toggleStatus($id)
    {
        $socio = Socio::findOrFail($id);
        // Cambiamos el estado al opuesto (si es 1 pasa a 0, y viceversa)
        $socio->activo = !$socio->activo;
        $socio->save();

        $mensaje = $socio->activo ? 'Socio activado correctamente.' : 'Socio desactivado correctamente.';
        return back()->with('success', $mensaje);
    }
    public function estadisticasVisitas()
    {
        // 1. Visitas totales por mes en el año actual
        $visitasEsteAnio = \App\Models\Visit::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // 2. Ranking de socios más activos (Top 10)
        $topVisitantes = \App\Models\Visit::with('user')
            ->selectRaw('user_id, COUNT(*) as total')
            ->groupBy('user_id')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        return view('admin.socios.visitas', compact('visitasEsteAnio', 'topVisitantes'));
    }
    public function adminDashboard()
    {
        // Estadísticas para las tarjetas
        $totalAhorrado = \App\Models\SavingsAccount::sum('balance');
        $totalPrestado = \App\Models\Prestamo::where('estado', 'activo')->sum('saldo_capital');
        $sociosActivos = \App\Models\Socio::where('activo', true)->count();

        // Datos para el gráfico (Últimos 6 meses)
        $meses = []; $ahorros = []; $prestamos = [];

        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $meses[] = $fecha->translatedFormat('F');

            $ahorros[] = \App\Models\SavingsTransaction::whereIn('type', ['deposit', 'interest'])
                ->whereMonth('date', $fecha->month)
                ->whereYear('date', $fecha->year)
                ->sum('amount');

            $prestamos[] = \App\Models\Prestamo::whereMonth('fecha_inicio', $fecha->month)
                ->whereYear('fecha_inicio', $fecha->year)
                ->sum('monto');
        }

        // Es vital que 'meses' esté aquí dentro
        return view('admin.dashboard', compact(
            'totalAhorrado', 'totalPrestado', 'sociosActivos',
            'meses', 'ahorros', 'prestamos'
        ));
    }
    public function dashboardSocio()
    {
        $socio = auth()->user()->socio;

        // Buscar cuentas por sus códigos (los que vimos en el Tinker)
        $cuentaApo = $socio->cuentas->whereIn('type.code', ['APO', 'aportacion'])->first();
        $cuentaVol = $socio->cuentas->whereIn('type.code', ['RET', 'voluntario'])->first();

        // Préstamos que el socio aún está pagando
        $prestamosActivos = $socio->prestamos()
            ->with('tipoPrestamo')
            ->where('estado', 'activo')
            ->get();

        return view('socio.dashboard', compact('socio', 'cuentaApo', 'cuentaVol', 'prestamosActivos'));
    }
}
