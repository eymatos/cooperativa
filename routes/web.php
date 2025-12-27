<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\AhorroController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\SocioController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\Admin\ExcedenteController;
use App\Exports\NominaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\HistorialAhorrosController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/* --------------------------------------------------------------------------
    RUTAS PÚBLICAS
-------------------------------------------------------------------------- */
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/quienes-somos', function () {
    return view('quienes-somos');
})->name('quienes-somos');

Route::get('/inscripcion', [SocioController::class, 'formulariosSocio'])->name('formularios.publicos');

// Rutas de Autenticación
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Solicitudes Públicas
Route::post('/solicitudes/guardar', [SolicitudController::class, 'store'])->name('solicitudes.store');
Route::get('/formularios/inscripcion', function () {
    return view('socio.formularios.inscripcion', ['publico' => !auth()->check()]);
})->name('socio.formularios.inscripcion');

/* --------------------------------------------------------------------------
    RUTAS PROTEGIDAS (AUTH)
-------------------------------------------------------------------------- */
Route::middleware(['auth', \App\Http\Middleware\LogUserVisit::class])->group(function () {

    Route::get('/dashboard', function () {
        $user = Auth::user();
        return ($user->tipo == 2) ? redirect()->route('admin.dashboard') : redirect()->route('socio.dashboard');
    })->name('dashboard');
});


    /* --------------------------------------------------------------------------
        AREA DE SOCIOS (Prefijo: socio / Nombre: socio.)
    -------------------------------------------------------------------------- */
    Route::prefix('socio')->name('socio.')->group(function () {
        Route::get('/', [SocioController::class, 'dashboardSocio'])->name('dashboard');
        Route::get('/calculadora', [PrestamoController::class, 'calculadoraSocio'])->name('calculadora');
        Route::get('/perfil', [SocioController::class, 'perfilSocio'])->name('perfil');
        Route::post('/perfil/update', [SocioController::class, 'updatePerfilSocio'])->name('perfil.update');

        Route::get('/mis-ahorros', [AhorroController::class, 'index'])->name('ahorros.index');
        Route::get('/mis-ahorros/{id}', [AhorroController::class, 'show'])->name('ahorros.show');
        Route::get('/mis-prestamos', [PrestamoController::class, 'misPrestamos'])->name('prestamos.mis_prestamos');
        Route::get('/mis-prestamos/{prestamo}', [PrestamoController::class, 'show'])->name('prestamos.show_socio');

        // Formularios Socio
        Route::get('/formularios', [SocioController::class, 'formulariosSocio'])->name('formularios');
        Route::get('/formularios/autorizacion-ahorro', function () { return view('socio.formularios.autorizacion_ahorro'); })->name('formularios.ahorro');
        Route::get('/formularios/inscripcion-ahorro-retirable', function () { return view('socio.formularios.inscripcion_retirable'); })->name('formularios.ahorro_retirable');
        Route::get('/formularios/gestion-ahorro-retirable', function () { return view('socio.formularios.gestion_retirable'); })->name('formularios.gestion_ahorro_retirable');
        Route::get('/formularios/solicitud-prestamo', function () { return view('socio.formularios.solicitud_prestamo'); })->name('formularios.prestamo');
        Route::get('/formularios/suspension-ahorro-retirable', function () { return view('socio.formularios.suspension_retirable'); })->name('formularios.suspension_ahorro_retirable');
        Route::get('/formularios/retiro-ahorro-retirable', function () { return view('socio.formularios.retiro_retirable'); })->name('formularios.retiro_retirable');
    });

    /* --------------------------------------------------------------------------
        AREA DE ADMINISTRADOR (Prefijo: admin / Nombre: admin.)
    -------------------------------------------------------------------------- */
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/', [SocioController::class, 'adminDashboard'])->name('dashboard');

        // Gestión de Socios
        Route::resource('socios', SocioController::class);
        Route::patch('/socios/{socio}/toggle-status', [SocioController::class, 'toggleStatus'])->name('socios.toggle_status');
        Route::get('socios/{socio}/prestamos/historial-pagados', [SocioController::class, 'showHistorialPrestamos'])->name('socios.historial.prestamos');
        Route::delete('/socios/limpiar-usuario/{id}', [SocioController::class, 'destroyUser'])->name('socios.limpiar');
        Route::post('prestamos/simular', [PrestamoController::class, 'simular'])->name('prestamos.simular');
        // RUTAS ESPECÍFICAS DE PRÉSTAMOS
        Route::get('/prestamos/{id}/liquidar/confirmar', [PrestamoController::class, 'confirmarLiquidacion'])->name('prestamos.liquidar.confirm');
        Route::post('/prestamos/{id}/liquidar/procesar', [PrestamoController::class, 'procesarLiquidacion'])->name('prestamos.liquidar.procesar');
        Route::patch('/prestamos/{id}/marcar-pagado', [PrestamoController::class, 'marcarPagado'])->name('prestamos.marcar-pagado');

        // Gestión de Préstamos Resource
        Route::resource('prestamos', PrestamoController::class);

        // Solicitudes Administrativas
        Route::get('/solicitudes', [SolicitudController::class, 'indexAdmin'])->name('solicitudes.index');
        Route::get('/solicitudes/{id}', [SolicitudController::class, 'showAdmin'])->name('solicitudes.show');
        Route::patch('/solicitudes/{id}/estado', [SolicitudController::class, 'updateEstado'])->name('solicitudes.estado');
        Route::get('/solicitudes/{id}/descargar', [SolicitudController::class, 'descargarPdf'])->name('solicitudes.descargar');

        // Caja, Pagos y Transacciones
        Route::get('/prestamos/{prestamo}/pagar', [PagoController::class, 'create'])->name('pagos.create');
        Route::post('/prestamos/{prestamo}/pagar', [PagoController::class, 'store'])->name('pagos.store');
        Route::put('/cuentas/update-cuota/{id}', [SocioController::class, 'updateCuota'])->name('cuentas.update_cuota');
        Route::post('/ahorros/transaccion', [SocioController::class, 'storeTransaction'])->name('ahorros.transaction.store');
        Route::put('/ahorros/transaccion/{id}', [SocioController::class, 'updateTransaction'])->name('ahorros.transaction.update');
        Route::delete('/ahorros/transaccion/{id}', [SocioController::class, 'destroyTransaction'])->name('ahorros.transaction.destroy');

        // Reportes
        Route::get('/vencimientos-prestamos', [PrestamoController::class, 'reporteVencimientos'])->name('prestamos.vencimientos');
        Route::get('/reportes/visitas', [SocioController::class, 'estadisticasVisitas'])->name('reportes.visitas');
        Route::get('/reportes/morosidad', [PrestamoController::class, 'reporteMorosidad'])->name('reportes.morosidad');
        Route::get('/reportes/utilidades', [ReporteController::class, 'utilidades'])->name('reportes.utilidades');
        Route::get('/reportes/proyeccion', [ReporteController::class, 'proyeccion'])->name('reportes.proyeccion');
        Route::get('/reportes/concentracion', [ReporteController::class, 'concentracion'])->name('reportes.concentracion');
        Route::get('/reportes/ahorros-pasivos', [ReporteController::class, 'ahorros'])->name('reportes.ahorros');
        Route::get('/reportes/informe-mensual', [ReporteController::class, 'informeMensual'])->name('reportes.mensual');
        Route::get('/reportes/variacion', [SocioController::class, 'variacionNomina'])->name('reportes.variacion');
        Route::get('/logs-auditoria', [SocioController::class, 'logs'])->name('logs.index');

        // Nómina (Exportación Excel)
        Route::get('/exportar-nomina/{tipo}', function ($tipo) {
            $nombre = "Nomina_" . ucfirst($tipo) . "_" . now()->format('m_Y') . ".xlsx";
            return Excel::download(new NominaExport($tipo), $nombre);
        })->name('reportes.nomina');

        // Módulo de Excedentes y Cierre Contable
        Route::prefix('excedentes')->name('excedentes.')->group(function () {
            Route::get('/informe', [ExcedenteController::class, 'informe'])->name('informe');
            Route::get('/', [ExcedenteController::class, 'index'])->name('index');
            Route::post('/', [ExcedenteController::class, 'store'])->name('store');
            Route::get('/gastos', [ExcedenteController::class, 'gastosIndex'])->name('gastos.index');
            Route::post('/gastos', [ExcedenteController::class, 'gastosStore'])->name('gastos.store');
            Route::delete('/gastos/{gasto}', [ExcedenteController::class, 'gastosDestroy'])->name('gastos.destroy');
        });

        // Importadores
        Route::get('/importar-socios', [App\Http\Controllers\Admin\ImportacionController::class, 'index'])->name('importar.index');
        Route::post('/importar-socios', [App\Http\Controllers\Admin\ImportacionController::class, 'store'])->name('importar.store');
        Route::get('importar/historial', [HistorialAhorrosController::class, 'index'])->name('importar.historial');
        Route::post('importar/historial', [HistorialAhorrosController::class, 'store'])->name('importar.historial.store');
        Route::get('importar/prestamos', [App\Http\Controllers\Admin\ImportacionPrestamosController::class, 'index'])->name('importar.prestamos');
        Route::post('importar/prestamos', [App\Http\Controllers\Admin\ImportacionPrestamosController::class, 'store'])->name('importar.prestamos.store');

        /**
         * RUTA DE REPARACIÓN FINAL
         * 1. Restaura intereses de todas las cuotas hasta Diciembre 2025.
         * 2. Asegura que las cuotas de Enero 2026 de préstamos saldados tengan interés 0.
         */
        Route::get('/mantenimiento/reparacion-final', function() {
            $conteo = 0;

            DB::transaction(function() use (&$conteo) {
                // Obtener todas las cuotas
                $cuotas = DB::table('cuotas')
                    ->join('prestamos', 'cuotas.prestamo_id', '=', 'prestamos.id')
                    ->select('cuotas.*', 'prestamos.estado as prestamo_estado', 'prestamos.tasa_interes', 'prestamos.monto as monto_prestamo')
                    ->get();

                foreach ($cuotas as $c) {
                    $fecha = Carbon::parse($c->fecha_vencimiento);
                    $esEnero2026 = ($fecha->year == 2026 && $fecha->month == 1);
                    $esPasado = $fecha->lte(Carbon::parse('2025-12-31'));

                    // CASO 1: Cuotas del 2025 hacia atrás
                    if ($esPasado) {
                        // Si el interés es 0 pero el monto_total es igual al capital,
                        // significa que fue borrado. Lo recalculamos por tasa.
                        // Usamos una lógica simplificada para no fallar:
                        // El interes original = cuota_fija - capital.
                        // Pero como no tenemos la cuota fija guardada, usaremos la fórmula del service.

                        $tasaMensual = ($c->tasa_interes / 100) / 12;
                        // Estimamos el saldo anterior basándonos en el saldo_restante + capital
                        $saldoAnterior = $c->saldo_restante + $c->capital;
                        $interesCalculado = round($saldoAnterior * $tasaMensual, 2);

                        DB::table('cuotas')->where('id', $c->id)->update([
                            'interes' => $interesCalculado,
                            'monto_total' => round($c->capital + $interesCalculado, 2),
                            'pagado' => round($c->capital + $interesCalculado, 2),
                            'abonado' => round($c->capital + $interesCalculado, 2),
                            'estado' => 'pagado' // Forzamos pagado hasta diciembre 2025
                        ]);
                    }
                    // CASO 2: Enero 2026 y el préstamo está pagado
                    elseif ($esEnero2026 && $c->prestamo_estado == 'pagado') {
                        DB::table('cuotas')->where('id', $c->id)->update([
                            'interes' => 0.00,
                            'monto_total' => $c->capital,
                            'pagado' => $c->capital,
                            'abonado' => $c->capital,
                            'estado' => 'pagado'
                        ]);
                    }
                    $conteo++;
                }
            });

            return "Reparación completada. Se han procesado " . $conteo . " cuotas.";
        });
    });
