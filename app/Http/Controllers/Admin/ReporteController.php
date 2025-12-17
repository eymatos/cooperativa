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
    // Suma de (capital + interes) de cuotas pendientes para los próximos 30 días
    $proxima30dias = \App\Models\Cuota::where('estado', 'pendiente')
        ->whereBetween('fecha_vencimiento', [now(), now()->addDays(30)])
        ->sum(\DB::raw('capital + interes'));

    // Suma de (capital + interes) de cuotas pendientes de 31 a 60 días
    $proxima60dias = \App\Models\Cuota::where('estado', 'pendiente')
        ->whereBetween('fecha_vencimiento', [now()->addDays(31), now()->addDays(60)])
        ->sum(\DB::raw('capital + interes'));

    // Opcional: Obtener los próximos 5 socios que deben pagar para mostrar en una lista
    $proximosCobros = \App\Models\Cuota::with(['prestamo.socio.user'])
        ->where('estado', 'pendiente')
        ->where('fecha_vencimiento', '>=', now())
        ->orderBy('fecha_vencimiento', 'asc')
        ->limit(5)
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
public function ahorrosPasivos()
{
    // Obtenemos los balances sumados usando Eloquent y sus relaciones
    // Esto evita errores de nombres de tablas manuales
    $distribucionAhorros = \App\Models\SavingsAccount::with('type')
        ->get()
        ->groupBy(function($account) {
            return $account->type->name ?? 'Sin Tipo';
        })
        ->map(function ($group) {
            return (object) [
                'tipo' => $group->first()->type->name ?? 'Sin Tipo',
                'total' => $group->sum('balance')
            ];
        });

    // Los 10 socios con más ahorros acumulados
    $topAhorrantes = \App\Models\Socio::with(['user', 'cuentas'])
        ->get()
        ->map(function ($socio) {
            $socio->cuentas_sum_balance = $socio->cuentas->sum('balance');
            return $socio;
        })
        ->sortByDesc('cuentas_sum_balance')
        ->take(10);

    $totalGeneralAhorros = $distribucionAhorros->sum('total');

    return view('admin.reportes.ahorros_pasivos', compact('distribucionAhorros', 'topAhorrantes', 'totalGeneralAhorros'));
}
}
