<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;
use App\Models\SavingType;
use App\Models\SavingsAccount;
use App\Models\SavingsTransaction;

class SocioController extends Controller
{
    // 1. LISTA DE SOCIOS (Buscador Inteligente Normalizado)
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');

        // 1. Buscamos en la tabla USUARIOS (User), filtrando solo los que son socios (tipo 0)
        // Usamos with('socio') para cargar su perfil de una vez
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
        $socio = Socio::with('user')->findOrFail($id);

        // --- LÓGICA DE PRÉSTAMOS ---
        $prestamosActivos = $socio->prestamos()->where('estado', '!=', 'pagado')->get();
        $prestamosInactivos = $socio->prestamos()->where('estado', '==', 'pagado')->get();
        $totalDeuda = $prestamosActivos->sum('saldo_capital');

        // --- LÓGICA DE AHORROS ---

        // 2. BUSCAR TIPOS DE AHORRO
        $tipoAportacion = SavingType::where('code', 'aportacion')->first();
        $tipoVoluntario = SavingType::where('code', 'voluntario')->first();

        // Validación simple por seguridad
        if (!$tipoAportacion || !$tipoVoluntario) {
            // Si es la primera vez y no hay seeds, evitar error 500
            return back()->with('error', 'Faltan configurar los tipos de ahorro en el sistema.');
        }

        // 3. BUSCAR O CREAR LAS CUENTAS (BILLETERAS)
        $cuentaAportacion = SavingsAccount::firstOrCreate(
            ['socio_id' => $socio->id, 'saving_type_id' => $tipoAportacion->id],
            ['balance' => 0, 'recurring_amount' => 0]
        );

        $cuentaVoluntario = SavingsAccount::firstOrCreate(
            ['socio_id' => $socio->id, 'saving_type_id' => $tipoVoluntario->id],
            ['balance' => 0, 'recurring_amount' => 0]
        );

        // 4. PREPARAR EL FILTRO DE AÑOS
        $cuentasIds = [$cuentaAportacion->id, $cuentaVoluntario->id];
        $aniosDisponibles = SavingsTransaction::whereIn('savings_account_id', $cuentasIds)
            ->selectRaw('YEAR(date) as anio')
            ->distinct()
            ->orderBy('anio', 'desc')
            ->pluck('anio');

        $anioSeleccionado = $request->get('anio_ahorro', date('Y'));

        // 5. FUNCIÓN MAESTRA: CONVERTIR DATA EN MATRIZ DE 12 MESES
        $armarMatrizMensual = function($cuenta) use ($anioSeleccionado) {
            $meses = [];
            // Inicializamos los 12 meses
            for ($i = 1; $i <= 12; $i++) {
                $meses[$i] = [
                    'aporte' => 0,
                    'retiro' => 0,
                    'comentarios' => []
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

                    if (!empty($tx->description)) {
                        $meses[$mes]['comentarios'][] = $tx->description;
                    }
                }
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
            'socio',
            'totalDeuda',
            'prestamosActivos',
            'prestamosInactivos',
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
