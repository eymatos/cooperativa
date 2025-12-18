<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function auditoria()
    {
        // Obtenemos los logs con el usuario que hizo la acción, ordenados por los más recientes
        $logs = ActivityLog::with('user')->latest()->paginate(15);

        return view('admin.reportes.auditoria', compact('logs'));
    }
public function utilidades()
{
    // Intereses cobrados este mes (Usamos updated_at que es cuando se procesó el pago)
    $interesesMesActual = \App\Models\Cuota::where('estado', 'pagada')
        ->whereMonth('updated_at', now()->month)
        ->whereYear('updated_at', now()->year)
        ->sum('interes');

    // Intereses cobrados el mes pasado
    $interesesMesPasado = \App\Models\Cuota::where('estado', 'pagada')
        ->whereMonth('updated_at', now()->subMonth()->month)
        ->whereYear('updated_at', now()->subMonth()->year)
        ->sum('interes');

    // Detalle de los últimos pagos (Cambiamos el orden a updated_at)
    $ultimosPagos = \App\Models\Cuota::with(['prestamo.socio.user'])
        ->where('estado', 'pagada')
        ->orderBy('updated_at', 'desc')
        ->limit(10)
        ->get();

    return view('admin.reportes.utilidades', compact('interesesMesActual', 'interesesMesPasado', 'ultimosPagos'));
}
public function proyeccion()
{
    // 1. SUMA TOTAL: Todo lo que diga "pendiente" en la base de datos (Sin filtro de fecha)
    $proxima30dias = \App\Models\Cuota::where('estado', 'pendiente')
        ->sum('monto_total');

    // 2. SUMA RECAUDADA: Todo lo que ya se cobró (Histórico)
    $proxima60dias = \App\Models\Cuota::where('estado', 'pagado')
        ->sum('monto_total');

    // 3. LISTADO: Las 50 cuotas pendientes más próximas a vencer
    $proximosCobros = \App\Models\Cuota::with(['prestamo.socio.user'])
        ->where('estado', 'pendiente')
        ->orderBy('fecha_vencimiento', 'asc')
        ->limit(50)
        ->get();

    return view('admin.reportes.proyeccion', compact('proxima30dias', 'proxima60dias', 'proximosCobros'));
}
public function concentracion()
{
    // Obtenemos la suma del saldo capital agrupado por el nombre del tipo de préstamo
    $datosCartera = \App\Models\Prestamo::join('tipo_prestamos', 'prestamos.tipo_prestamo_id', '=', 'tipo_prestamos.id')
        ->selectRaw('tipo_prestamos.nombre as tipo, SUM(prestamos.saldo_capital) as total')
        ->where('prestamos.estado', 'activo')
        ->groupBy('tipo_prestamos.nombre')
        ->get();

    $labels = $datosCartera->pluck('tipo');
    $valores = $datosCartera->pluck('total');

    return view('admin.reportes.concentracion', compact('labels', 'valores', 'datosCartera'));
}
public function ahorros()
{
    // 1. Obtenemos la distribución agrupada por el nombre del tipo de ahorro
    $distribucionAhorros = \App\Models\SavingsAccount::join('saving_types', 'savings_accounts.saving_type_id', '=', 'saving_types.id')
        ->selectRaw('saving_types.name as tipo, SUM(savings_accounts.balance) as total')
        ->groupBy('saving_types.name')
        ->get();

    // 2. Los 10 socios con más ahorros acumulados (Consultando directo a la BD para mejor rendimiento)
    $topAhorrantes = \App\Models\Socio::with(['user'])
        ->withSum('cuentas as cuentas_sum_balance', 'balance')
        ->orderBy('cuentas_sum_balance', 'desc')
        ->limit(10)
        ->get();

    $totalGeneralAhorros = $distribucionAhorros->sum('total');

    // Retornamos la vista (Asegúrate de que el nombre del archivo sea exacto)
    return view('admin.reportes.ahorros_pasivos', compact(
        'distribucionAhorros',
        'topAhorrantes',
        'totalGeneralAhorros'
    ));
}
// app/Http/Controllers/Admin/ReporteController.php

public function informeMensual()
{
    $inicioMes = now()->startOfMonth();
    $finMes = now()->endOfMonth();

    // 1. Conteo simple de socios nuevos (sin usar tipo_contrato aún)
    $totalNuevosSocios = \App\Models\Socio::whereBetween('created_at', [$inicioMes, $finMes])->count();

    // 2. Dinero prestado en el mes
    $totalDesembolsado = \App\Models\Prestamo::whereBetween('created_at', [$inicioMes, $finMes])
        ->where('estado', 'activo')
        ->sum('monto');

    // 3. Recaudación total del mes
    $recaudacion = \App\Models\Cuota::where('estado', 'pagada')
        ->whereBetween('updated_at', [$inicioMes, $finMes])
        ->selectRaw('SUM(capital) as capital, SUM(interes) as interes')
        ->first();

    return view('admin.reportes.informe_mensual', compact(
        'totalNuevosSocios',
        'totalDesembolsado',
        'recaudacion',
        'inicioMes'
    ));
}
// app/Http/Controllers/AdminController.php

public function logs() {
    // Traemos los registros de actividad con el nombre del usuario que lo hizo
    $logs = \App\Models\ActivityLog::with('user')
        ->latest() // Del más reciente al más antiguo
        ->paginate(20); // De 20 en 20 para no saturar la página

    return view('admin.logs.index', compact('logs'));
}
public function variacionNomina() {
    // 1. Sumamos todos los ahorros fijos que tienen los socios hoy
    $ahorrosActuales = \App\Models\SavingsAccount::sum('recurring_amount');

    // 2. Sumamos las cuotas de préstamos que vencen este mes y están pendientes
    $cuotasMes = \App\Models\Cuota::where('estado', 'pendiente')
        ->whereMonth('fecha_pago', now()->month)
        ->whereYear('fecha_pago', now()->year)
        ->sum(\DB::raw('capital + interes'));

    $totalNominaActual = $ahorrosActuales + $cuotasMes;

    return view('admin.reportes.variacion', [
        'total' => $totalNominaActual,
        'ahorros' => $ahorrosActuales,
        'prestamos' => $cuotasMes,
        'mes' => now()->translatedFormat('F Y')
    ]);
}
}
