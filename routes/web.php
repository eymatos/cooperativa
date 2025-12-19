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

    Route::post('prestamos/simular', [PrestamoController::class, 'simular'])->name('prestamos.simular');

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

        // Gestión de Socios y Préstamos
        Route::resource('socios', SocioController::class);
        Route::resource('prestamos', PrestamoController::class);
        Route::patch('/socios/{socio}/toggle-status', [SocioController::class, 'toggleStatus'])->name('socios.toggle_status');
        Route::get('socios/{socio}/prestamos/historial-pagados', [SocioController::class, 'showHistorialPrestamos'])->name('socios.historial.prestamos');
        Route::delete('/socios/limpiar-usuario/{id}', [SocioController::class, 'destroyUser'])->name('socios.limpiar');

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

        // Módulo de Excedentes y Cierre Contable (Ley 127-64)
Route::prefix('excedentes')->name('excedentes.')->group(function () {
    // Informe Final y Cierre
    Route::get('/informe', [ExcedenteController::class, 'informe'])->name('informe');
    Route::get('/', [ExcedenteController::class, 'index'])->name('index');
    Route::post('/', [ExcedenteController::class, 'store'])->name('store');

    // Gestión de Gastos Operativos (Nómina, Banco, Eventos, etc.)
    Route::get('/gastos', [ExcedenteController::class, 'gastosIndex'])->name('gastos.index');
    Route::post('/gastos', [ExcedenteController::class, 'gastosStore'])->name('gastos.store');
    Route::delete('/gastos/{gasto}', [ExcedenteController::class, 'gastosDestroy'])->name('gastos.destroy');
});
    });
});
