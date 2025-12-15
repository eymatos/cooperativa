<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SocioController extends Controller
{
    // 1. LISTA DE SOCIOS (Buscador)
    public function index(Request $request)
    {
        $query = User::where('tipo', 0); // Solo socios

        if ($request->has('buscar') && $request->buscar != '') {
            $busqueda = $request->buscar;
            $query->where(function($q) use ($busqueda) {
                $q->where('nombres', 'LIKE', "%$busqueda%")
                  ->orWhere('apellidos', 'LIKE', "%$busqueda%")
                  ->orWhere('cedula', 'LIKE', "%$busqueda%");
            });
        }

        $socios = $query->paginate(10);

        return view('admin.socios.index', compact('socios'));
    }

    // 2. PERFIL 360 DEL SOCIO
    public function show(Request $request, $id)
    {
        // 1. CARGAR DATOS
        // Buscamos al socio y traemos la información de su usuario
        $socio = \App\Models\Socio::with('user')->findOrFail($id);

        // --- LÓGICA DE PRÉSTAMOS (Tu código original) ---
        $prestamosActivos = $socio->prestamos()->where('estado', '!=', 'pagado')->get();
        $prestamosInactivos = $socio->prestamos()->where('estado', '==', 'pagado')->get();
        $totalDeuda = $prestamosActivos->sum('saldo_capital');

        // --- LÓGICA DE AHORROS ---

        // 2. BUSCAR O CREAR LAS CUENTAS (BILLETERAS)
        // Buscamos los IDs de los tipos de ahorro
        $tipoAportacion = \App\Models\SavingType::where('code', 'aportacion')->first();
        $tipoVoluntario = \App\Models\SavingType::where('code', 'voluntario')->first();

        // firstOrCreate: Si la cuenta existe, la trae. Si no, la crea con balance 0.
        // Esto evita errores si entras al perfil de un socio nuevo.
        $cuentaAportacion = \App\Models\SavingsAccount::firstOrCreate(
            ['socio_id' => $socio->id, 'saving_type_id' => $tipoAportacion->id],
            ['balance' => 0, 'recurring_amount' => 0]
        );

        $cuentaVoluntario = \App\Models\SavingsAccount::firstOrCreate(
            ['socio_id' => $socio->id, 'saving_type_id' => $tipoVoluntario->id],
            ['balance' => 0, 'recurring_amount' => 0]
        );

        // 3. PREPARAR EL FILTRO DE AÑOS
        // Buscamos en todas las transacciones de estas cuentas qué años tienen movimientos
        $cuentasIds = [$cuentaAportacion->id, $cuentaVoluntario->id];
        $aniosDisponibles = \App\Models\SavingsTransaction::whereIn('savings_account_id', $cuentasIds)
            ->selectRaw('YEAR(date) as anio')
            ->distinct()
            ->orderBy('anio', 'desc')
            ->pluck('anio');

        // Determinamos qué año quiere ver el usuario (o el actual por defecto)
        $anioSeleccionado = $request->get('anio_ahorro', date('Y'));


       // 4. FUNCIÓN MAESTRA: CONVERTIR DATA EN MATRIZ DE 12 MESES
        $armarMatrizMensual = function($cuenta) use ($anioSeleccionado) {
            $meses = [];
            // Inicializamos los 12 meses
            for ($i = 1; $i <= 12; $i++) {
                $meses[$i] = [
                    'aporte' => 0,
                    'retiro' => 0,
                    'comentarios' => [] // Array para guardar múltiples notas
                ];
            }

            if ($anioSeleccionado != 'todos') {
                $transacciones = $cuenta->transactions()
                    ->whereYear('date', $anioSeleccionado)
                    ->get();

                foreach ($transacciones as $tx) {
                    $mes = $tx->date->month;

                    if ($tx->type == 'deposit' || $tx->type == 'interest') {
                        $meses[$mes]['aporte'] += $tx->amount;
                    } elseif ($tx->type == 'withdrawal') {
                        $meses[$mes]['retiro'] += $tx->amount;
                    }

                    // Si hay comentario, lo agregamos a la lista de ese mes
                    if (!empty($tx->description)) {
                        // Ejemplo: "Excedente (RD$ 200)"
                        $meses[$mes]['comentarios'][] = $tx->description;
                    }
                }
            }
            return $meses;
        };

        // 5. EJECUTAMOS LA FUNCIÓN PARA AMBAS CUENTAS
        $matrizAportacion = $armarMatrizMensual($cuentaAportacion);
        $matrizVoluntario = $armarMatrizMensual($cuentaVoluntario);

        // 6. TOTALES GENERALES (Histórico completo)
        $totalAportaciones = $cuentaAportacion->balance;
        $totalRetirable = $cuentaVoluntario->balance;
        $totalAhorradoGlobal = $totalAportaciones + $totalRetirable;

        // 7. ENVIAR A LA VISTA
        return view('admin.socios.show', compact(
            'socio',
            'totalDeuda',
            'prestamosActivos',
            'prestamosInactivos',
            // Variables de Ahorro
            'aniosDisponibles',
            'anioSeleccionado',
            'matrizAportacion',
            'matrizVoluntario',
            'cuentaAportacion',
            'cuentaVoluntario',
            'totalAportaciones',
            'totalRetirable',
            'totalAhorradoGlobal'
        ));
    }
}
