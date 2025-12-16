<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;
use App\Models\SavingType;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;
use Carbon\Carbon;

class SocioController extends Controller
{
    // 1. LISTA DE SOCIOS (Buscador Inteligente Normalizado)
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');

        // 1. Buscamos en la tabla USUARIOS (User), filtrando solo los que son socios (tipo 0)
        $socios = \App\Models\User::where('tipo', 0)
            ->with('socio')
            ->when($buscar, function ($query) use ($buscar) {
                return $query->where(function ($q) use ($buscar) {

                    // A. Buscar por Cédula (Directamente en tabla users)
                    $q->where('cedula', 'LIKE', "%$buscar%")

                    // B. Buscar por Nombre de Usuario (backup)
                      ->orWhere('name', 'LIKE', "%$buscar%")

                    // C. Buscar por Nombres/Apellidos (Dentro de la relación 'socio')
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
}
