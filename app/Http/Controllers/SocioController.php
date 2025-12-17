<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;
use App\Models\SavingType;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use App\Models\Cuota;
use App\Models\Prestamo;
use App\Models\ActivityLog;
use App\Models\Visit;
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

        $socios = User::where('tipo', 0)
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

    public function create()
    {
        return view('admin.socios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cedula'    => 'required|unique:users,cedula',
            'nombres'   => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'sueldo'    => 'required|numeric',
            'salario'   => 'required|numeric|min:0',
            'tipo_contrato' => 'required|in:fijo,contratado',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $user = User::create([
                    'name'     => $request->nombres . ' ' . $request->apellidos,
                    'email'    => $request->email,
                    'cedula'   => $request->cedula,
                    'password' => Hash::make($request->password),
                    'tipo'     => 0,
                ]);

                $user->socio()->create([
                    'nombres'       => $request->nombres,
                    'apellidos'     => $request->apellidos,
                    'telefono'      => $request->telefono,
                    'direccion'     => $request->direccion,
                    'sueldo'        => $request->sueldo,
                    'salario'       => $request->salario,
                    'lugar_trabajo' => $request->lugar_trabajo,
                    'tipo_contrato' => $request->tipo_contrato,
                    'ahorro_total'  => 0,
                ]);

                return redirect()->route('admin.socios.index')
                    ->with('success', 'Socio y Usuario creados exitosamente.');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Error al registrar: ' . $e->getMessage())->withInput();
        }
    }

    // 2. PERFIL 360 DEL SOCIO (CORREGIDO)
    public function show(Request $request, $id)
    {
        // 1. CARGAR DATOS BASE
        $socio = Socio::with(['user', 'prestamos.cuotas', 'cuentas.type'])->findOrFail($id);

        // --- LÓGICA DE AHORROS ---
        $tipoAportacion = SavingType::where('code', 'aportacion')->first();
        $tipoVoluntario = SavingType::where('code', 'voluntario')->first();

        if (!$tipoAportacion || !$tipoVoluntario) {
            return back()->with('error', 'Faltan configurar los tipos de ahorro.');
        }

        $cuentaAportacion = SavingsAccount::firstOrCreate(
            ['socio_id' => $socio->id, 'saving_type_id' => $tipoAportacion->id],
            ['balance' => 0, 'recurring_amount' => 0]
        );

        $cuentaVoluntario = SavingsAccount::firstOrCreate(
            ['socio_id' => $socio->id, 'saving_type_id' => $tipoVoluntario->id],
            ['balance' => 0, 'recurring_amount' => 0]
        );

        $totalAportaciones = $cuentaAportacion->balance;
        $totalRetirable = $cuentaVoluntario->balance;
        $totalAhorradoGlobal = $totalAportaciones + $totalRetirable;

        // --- MOTOR DE RIESGO ---
        $salario = $socio->salario ?? 0;
        $maximoCreditoPosible = $totalAhorradoGlobal * 1.5; // REGLA 1.5x Ahorros
        $limiteMensualDescuento = $salario * 0.40; // REGLA 40% Salario

        // 1. Calculamos la cuota de préstamos (Si hay préstamo activo, hay descuento)
        $cuotasPrestamosMes = $socio->prestamos()
            ->where('estado', 'activo')
            ->get()
            ->sum(function($prestamo) {
                // Buscamos la siguiente cuota a cobrar
                $cuota = $prestamo->cuotas()->where('estado', 'pendiente')->orderBy('numero_cuota', 'asc')->first();
                return $cuota ? $cuota->monto_total : 0;
            });

        // 2. Ahorros fijos configurados
        $ahorrosFijosMes = $cuentaAportacion->recurring_amount + $cuentaVoluntario->recurring_amount;

        // 3. Compromisos Totales (Lo que sale en el recibo oscuro)
        $compromisosActuales = $cuotasPrestamosMes + $ahorrosFijosMes;
        $capacidadDisponibleMensual = $limiteMensualDescuento - $compromisosActuales;

        // --- PRÉSTAMOS PARA VISTA ---
        $prestamosActivos = $socio->prestamos()->where('estado', '!=', 'pagado')->get();
        $prestamosInactivos = $socio->prestamos()->where('estado', 'pagado')->get();
        $totalDeuda = $prestamosActivos->sum('saldo_capital');

        // --- HISTÓRICO DE AHORROS ---
        $cuentasIds = [$cuentaAportacion->id, $cuentaVoluntario->id];
        $aniosBD = SavingsTransaction::whereIn('savings_account_id', $cuentasIds)
            ->selectRaw('YEAR(date) as anio')->distinct()->pluck('anio')->toArray();
        $aniosDisponibles = array_unique(array_merge($aniosBD, [(int)date('Y')]));
        rsort($aniosDisponibles);
        $anioSeleccionado = $request->get('anio_ahorro', (string)date('Y'));

        $armarMatriz = function($cuenta) use ($anioSeleccionado) {
            $meses = [];
            for ($i = 1; $i <= 12; $i++) { $meses[$i] = ['aporte' => 0, 'retiro' => 0, 'transacciones' => []]; }
            $txs = $cuenta->transactions()->whereYear('date', $anioSeleccionado)->get();
            foreach ($txs as $tx) {
                $m = $tx->date->month;
                if ($tx->type == 'deposit' || $tx->type == 'interest') $meses[$m]['aporte'] += $tx->amount;
                else $meses[$m]['retiro'] += $tx->amount;
                $meses[$m]['transacciones'][] = $tx;
            }
            return $meses;
        };

        $matrizAportacion = $armarMatriz($cuentaAportacion);
        $matrizVoluntario = $armarMatriz($cuentaVoluntario);

        return view('admin.socios.show', [
            'socio' => $socio,
            'totalDeuda' => $totalDeuda,
            'prestamosActivos' => $prestamosActivos,
            'prestamosInactivos' => $prestamosInactivos,
            'totalAportaciones' => $totalAportaciones,
            'totalRetirable' => $totalRetirable,
            'totalAhorradoGlobal' => $totalAhorradoGlobal,
            'salario' => $salario,
            'limiteMensual' => $limiteMensualDescuento,
            'compromisosActuales' => $compromisosActuales,
            'cuotasPrestamos' => $cuotasPrestamosMes, // Enviado para desglose
            'ahorrosFijos' => $ahorrosFijosMes,       // Enviado para desglose
            'capacidadDisponible' => $capacidadDisponibleMensual,
            'maximoCredito' => $maximoCreditoPosible,
            'aniosDisponibles' => $aniosDisponibles,
            'anioSeleccionado' => $anioSeleccionado,
            'matrizAportacion' => $matrizAportacion,
            'matrizVoluntario' => $matrizVoluntario,
            'cuentaAportacion' => $cuentaAportacion,
            'cuentaVoluntario' => $cuentaVoluntario,
        ]);
    }

    public function showHistorialPrestamos(Socio $socio)
    {
        $prestamosPagados = $socio->prestamos()->where('estado', 'pagado')->orderBy('fecha_inicio', 'desc')->get();
        return view('admin.socios.historial_prestamos', compact('socio', 'prestamosPagados'));
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'savings_account_id' => 'required|exists:savings_accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:deposit,withdrawal',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255'
        ]);

        $cuenta = SavingsAccount::findOrFail($request->savings_account_id);
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

        return redirect()->route('admin.socios.show', [
            'socio' => $cuenta->socio_id,
            'anio_ahorro' => Carbon::parse($tx->date)->year
        ])->with('success', 'Transacción registrada.');
    }

    public function updateTransaction(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255'
        ]);

        $tx = SavingsTransaction::findOrFail($id);
        $cuenta = $tx->account;

        // Revertir balance anterior
        if ($tx->type == 'deposit' || $tx->type == 'interest') $cuenta->balance -= $tx->amount;
        else $cuenta->balance += $tx->amount;

        $tx->update($request->only('amount', 'date', 'description'));

        // Aplicar nuevo balance
        if ($tx->type == 'deposit' || $tx->type == 'interest') $cuenta->balance += $tx->amount;
        else $cuenta->balance -= $tx->amount;

        $cuenta->save();

        return redirect()->route('admin.socios.show', [
            'socio' => $cuenta->socio_id,
            'anio_ahorro' => Carbon::parse($request->date)->year
        ])->with('success', 'Transacción actualizada.');
    }

    public function destroyTransaction($id)
    {
        $tx = SavingsTransaction::findOrFail($id);
        $cuenta = $tx->account;

        if ($tx->type == 'deposit' || $tx->type == 'interest') $cuenta->balance -= $tx->amount;
        else $cuenta->balance += $tx->amount;

        $cuenta->save();
        $tx->delete();

        return back()->with('success', 'Transacción eliminada.');
    }

    public function updateCuota(Request $request, $id)
    {
        $request->validate(['recurring_amount' => 'required|numeric|min:0']);
        $cuenta = SavingsAccount::findOrFail($id);
        $cuenta->update(['recurring_amount' => $request->recurring_amount]);
        return back()->with('success', 'Cuota actualizada.');
    }

    public function toggleStatus($id)
    {
        $socio = Socio::findOrFail($id);
        $socio->update(['activo' => !$socio->activo]);
        return back()->with('success', $socio->activo ? 'Socio activado.' : 'Socio desactivado.');
    }

    public function estadisticasVisitas()
    {
        $visitasEsteAnio = Visit::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('mes')->orderBy('mes')->get();

        $topVisitantes = Visit::with('user')
            ->selectRaw('user_id, COUNT(*) as total')
            ->groupBy('user_id')->orderBy('total', 'desc')->limit(10)->get();

        return view('admin.socios.visitas', compact('visitasEsteAnio', 'topVisitantes'));
    }

    public function adminDashboard()
    {
        $totalAhorrado = SavingsAccount::sum('balance');
        $totalPrestado = Prestamo::where('estado', 'activo')->sum('saldo_capital');
        $sociosActivos = Socio::where('activo', true)->count();

        $meses = []; $ahorros = []; $prestamos = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $meses[] = $fecha->translatedFormat('F');
            $ahorros[] = SavingsTransaction::whereIn('type', ['deposit', 'interest'])
                ->whereMonth('date', $fecha->month)->whereYear('date', $fecha->year)->sum('amount');
            $prestamos[] = Prestamo::whereMonth('fecha_inicio', $fecha->month)
                ->whereYear('fecha_inicio', $fecha->year)->sum('monto');
        }

        return view('admin.dashboard', compact('totalAhorrado', 'totalPrestado', 'sociosActivos', 'meses', 'ahorros', 'prestamos'));
    }

    public function variacionNomina() {
        $ahorrosActuales = SavingsAccount::sum('recurring_amount');
        $cuotasMes = Cuota::where('estado', 'pendiente')
            ->whereMonth('fecha_vencimiento', now()->month)
            ->whereYear('fecha_vencimiento', now()->year)
            ->sum('monto_total');

        return view('admin.reportes.variacion', [
            'total' => $ahorrosActuales + $cuotasMes,
            'ahorros' => $ahorrosActuales,
            'prestamos' => $cuotasMes,
            'mes' => now()->translatedFormat('F Y')
        ]);
    }

    public function logs()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('admin.logs.index', compact('logs'));
    }
}
