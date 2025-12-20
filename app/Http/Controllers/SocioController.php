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
use App\Models\Solicitud;

class SocioController extends Controller
{
    // 1. LISTA DE SOCIOS (Actualizado con Buscador y Ordenamiento Dinámico)
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');

        // Parámetros de ordenamiento
        $sort = $request->get('sort', 'id'); // Columna por defecto
        $direction = $request->get('direction', 'desc'); // Dirección por defecto

        // Definimos columnas permitidas para evitar inyecciones SQL
        $columnasPermitidas = ['id', 'name', 'cedula', 'created_at', 'activo'];
        if (!in_array($sort, $columnasPermitidas)) {
            $sort = 'id';
        }

        $socios = User::where('users.tipo', 0) // Especificamos tabla para evitar ambigüedad en Joins
            ->with(['socio.cuentas.type'])
            ->when($buscar, function ($query) use ($buscar) {
                return $query->where(function ($q) use ($buscar) {
                    $q->where('users.cedula', 'LIKE', "%$buscar%")
                      ->orWhere('users.name', 'LIKE', "%$buscar%")
                      ->orWhereHas('socio', function ($sq) use ($buscar) {
                          $sq->where('nombres', 'LIKE', "%$buscar%")
                             ->orWhere('apellidos', 'LIKE', "%$buscar%");
                      });
                });
            })
            // Lógica para ordenar: Si es por "activo" usamos el Join con la tabla socios
            ->when($sort == 'activo', function($query) use ($direction) {
                return $query->leftJoin('socios', 'users.id', '=', 'socios.user_id')
                             ->orderBy('socios.activo', $direction)
                             ->select('users.*');
            }, function($query) use ($sort, $direction) {
                return $query->orderBy("users.$sort", $direction);
            })
            ->paginate(10);

        // Adjuntamos los parámetros a los links de paginación para que no se pierdan al cambiar de página
        $socios->appends([
            'buscar' => $buscar,
            'sort' => $sort,
            'direction' => $direction
        ]);

        return view('admin.socios.index', compact('socios', 'sort', 'direction'));
    }

    public function create()
    {
        return view('admin.socios.create');
    }

    // MÉTODO STORE ACTUALIZADO: Contraseña por defecto coo123perativa
    public function store(Request $request)
    {
        $request->validate([
            'cedula'    => 'required|unique:users,cedula',
            'nombres'   => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'sueldo'    => 'required|numeric|min:0',
            'tipo_contrato' => 'required|in:fijo,contratado',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $user = User::create([
                    'name'     => $request->nombres . ' ' . $request->apellidos,
                    'email'    => $request->email,
                    'cedula'   => $request->cedula,
                    'password' => Hash::make('coo123perativa'),
                    'tipo'     => 0,
                ]);

                $user->socio()->create([
                    'nombres'       => $request->nombres,
                    'apellidos'     => $request->apellidos,
                    'telefono'      => $request->telefono,
                    'direccion'     => $request->direccion,
                    'sueldo'        => $request->sueldo,
                    'salario'       => $request->sueldo,
                    'lugar_trabajo' => $request->lugar_trabajo,
                    'tipo_contrato' => $request->tipo_contrato,
                    'ahorro_total'  => 0,
                ]);

                return redirect()->route('admin.socios.index')
                    ->with('success', 'Socio registrado exitosamente con clave: coo123perativa');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    // 2. PERFIL 360 DEL SOCIO
    public function show(Request $request, $id)
    {
        $socio = Socio::with(['user', 'prestamos.cuotas', 'cuentas.type'])->findOrFail($id);

        $tipoAportacion = SavingType::find(1);
        $tipoVoluntario = SavingType::find(2);

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

        $totalAportaciones = (float) $cuentaAportacion->balance;
        $totalRetirable = (float) $cuentaVoluntario->balance;
        $totalAhorradoGlobal = $totalAportaciones + $totalRetirable;

        $salario = (float) ($socio->salario ?? 0);
        $maximoCreditoPosible = $totalAhorradoGlobal * 1.5;
        $limiteMensualDescuento = $salario * 0.40;

        $cuotasPrestamosMes = $socio->prestamos()
            ->where('estado', 'activo')
            ->get()
            ->sum(function($prestamo) {
                $cuota = $prestamo->cuotas()->where('estado', 'pendiente')->orderBy('numero_cuota', 'asc')->first();
                return $cuota ? $cuota->monto_total : 0;
            });

        $ahorrosFijosMes = (float) ($cuentaAportacion->recurring_amount + $cuentaVoluntario->recurring_amount);
        $compromisosActuales = $cuotasPrestamosMes + $ahorrosFijosMes;
        $capacidadDisponibleMensual = $limiteMensualDescuento - $compromisosActuales;

        $prestamosActivos = $socio->prestamos()->where('estado', '!=', 'pagado')->get();
        $prestamosInactivos = $socio->prestamos()->where('estado', 'pagado')->get();
        $totalDeuda = $prestamosActivos->sum('saldo_capital');

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
                if (in_array($tx->type, ['deposit', 'interest', 'deposito'])) $meses[$m]['aporte'] += (float)$tx->amount;
                else $meses[$m]['retiro'] += (float)$tx->amount;
                $meses[$m]['transacciones'][] = $tx;
            }
            return $meses;
        };

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
            'cuotasPrestamos' => $cuotasPrestamosMes,
            'ahorrosFijos' => $ahorrosFijosMes,
            'capacidadDisponible' => $capacidadDisponibleMensual,
            'maximoCredito' => $maximoCreditoPosible,
            'aniosDisponibles' => $aniosDisponibles,
            'anioSeleccionado' => $anioSeleccionado,
            'matrizAportacion' => $armarMatriz($cuentaAportacion),
            'matrizVoluntario' => $armarMatriz($cuentaVoluntario),
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

        if ($tx->type == 'deposit' || $tx->type == 'interest') $cuenta->balance -= $tx->amount;
        else $cuenta->balance += $tx->amount;

        $tx->update($request->only('amount', 'date', 'description'));

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

        for ($i = 11; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $meses[] = ucfirst($fecha->translatedFormat('M y'));
            $start = $fecha->copy()->startOfMonth()->format('Y-m-d');
            $end = $fecha->copy()->endOfMonth()->format('Y-m-d');

            $ahorros[] = SavingsTransaction::whereIn('type', ['deposit', 'interest', 'deposito'])
                ->whereBetween('date', [$start, $end])->sum('amount');

            $prestamos[] = Prestamo::whereBetween('fecha_inicio', [$start, $end])->sum('monto');
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

    public function dashboardSocio(Request $request)
    {
        $user = auth()->user();
        $socio = Socio::with(['user', 'prestamos.cuotas', 'cuentas.type'])
                      ->where('user_id', $user->id)
                      ->firstOrFail();

        $cuentaAportacion = $socio->cuentas->filter(function($c) {
            return in_array(strtoupper($c->type->code), ['APO', 'APORTACION', 'APORTACIONES']);
        })->first();

        $cuentaVoluntario = $socio->cuentas->filter(function($c) {
            return in_array(strtoupper($c->type->code), ['RET', 'VOLUNTARIO', 'AHORRO']);
        })->first();

        $anioSeleccionado = $request->get('anio_ahorro', date('Y'));

        $armarMatriz = function($cuenta) use ($anioSeleccionado) {
            $meses = [];
            for ($i = 1; $i <= 12; $i++) { $meses[$i] = ['aporte' => 0, 'retiro' => 0]; }
            if ($cuenta) {
                $txs = $cuenta->transactions()->whereYear('date', $anioSeleccionado)->get();
                foreach ($txs as $tx) {
                    $m = \Carbon\Carbon::parse($tx->date)->month;
                    if (in_array($tx->type, ['deposit', 'interest', 'deposito'])) $meses[$m]['aporte'] += (float)$tx->amount;
                    else $meses[$m]['retiro'] += (float)$tx->amount;
                }
            }
            return $meses;
        };

        return view('socio.dashboard', [
            'socio' => $socio,
            'prestamosActivos' => $socio->prestamos()->where('estado', 'activo')->get(),
            'totalAhorradoGlobal' => ($cuentaAportacion->balance ?? 0) + ($cuentaVoluntario->balance ?? 0),
            'maximoCredito' => (($cuentaAportacion->balance ?? 0) + ($cuentaVoluntario->balance ?? 0)) * 1.5,
            'capacidadDisponible' => ($socio->salario * 0.40) - ($socio->prestamos()->where('estado', 'activo')->get()->sum(function($p){
                 $c = $p->cuotas()->where('estado', 'pendiente')->orderBy('numero_cuota', 'asc')->first();
                 return $c ? $c->monto_total : 0;
            }) + ($cuentaAportacion->recurring_amount ?? 0) + ($cuentaVoluntario->recurring_amount ?? 0)),
            'matrizAportacion' => $armarMatriz($cuentaAportacion),
            'matrizVoluntario' => $armarMatriz($cuentaVoluntario),
            'cuentaApo' => $cuentaAportacion,
            'cuentaVol' => $cuentaVoluntario,
            'anioSeleccionado' => $anioSeleccionado,
            'aniosDisponibles' => [date('Y'), date('Y')-1]
        ]);
    }

    public function perfilSocio()
    {
        $user = auth()->user();
        $socio = $user->socio;
        return view('socio.perfil', compact('user', 'socio'));
    }

    public function updatePerfilSocio(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);
        $user->email = $request->email;
        if ($request->filled('password')) $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function formulariosSocio()
    {
        $publico = request()->routeIs('formularios.publicos') || !auth()->check();
        return view('socio.formularios', compact('publico'));
    }

    public function destroyUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $cedula = $user->cedula;
            $solicitud = Solicitud::where('datos->cedula', $cedula)->where('estado', 'procesada')->first();
            if ($solicitud) $solicitud->update(['estado' => 'pendiente']);
            if ($user->socio) $user->socio->delete();
            $user->delete();
            return redirect()->back()->with('success', '✅ Usuario eliminado y solicitud reseteada a pendiente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al limpiar registros: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $socio = Socio::findOrFail($id);
        $request->validate([
            'nombres'   => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'salario'   => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request, $socio) {
                $socio->user->update(['name' => $request->nombres . ' ' . $request->apellidos]);
                $socio->update([
                    'nombres'   => $request->nombres,
                    'apellidos' => $request->apellidos,
                    'salario'   => $request->salario,
                    'sueldo'    => $request->salario,
                ]);
            });
            return back()->with('success', '✅ Perfil y salario actualizados correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }
}
