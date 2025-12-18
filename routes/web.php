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
use App\Exports\NominaExport;
use Maatwebsite\Excel\Facades\Excel;

/* --------------------------------------------------------------------------
   RUTAS PÚBLICAS (Visitantes y Aspirantes)
-------------------------------------------------------------------------- */
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/quienes-somos', function () {
    return view('quienes-somos');
})->name('quienes-somos');

// Formulario de inscripción público para no socios
Route::get('/inscripcion', [SocioController::class, 'formulariosSocio'])->name('formularios.publicos');

// Rutas de Autenticación
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta para guardar solicitudes (tanto públicas como privadas)
Route::post('/solicitudes/guardar', [SolicitudController::class, 'store'])->name('solicitudes.store');
// En web.php
Route::get('/formularios/inscripcion', function () {
    // Detectamos si es público o si el socio está logueado
    return view('socio.formularios.inscripcion', ['publico' => !auth()->check()]);
})->name('socio.formularios.inscripcion');

/* --------------------------------------------------------------------------
   RUTAS PROTEGIDAS (Requieren Login)
-------------------------------------------------------------------------- */
Route::middleware(['auth', \App\Http\Middleware\LogUserVisit::class])->group(function () {

    Route::get('/dashboard', function () {
        $user = Auth::user();
        return ($user->tipo == 2) ? redirect()->route('admin.dashboard') : redirect()->route('socio.dashboard');
    })->name('dashboard');

    Route::post('prestamos/simular', [PrestamoController::class, 'simular'])->name('prestamos.simular');

    /* --------------------------------------------------------------------------
       AREA DE SOCIOS (Tipo 0)
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

        // Centro de servicios digitales para el socio
        Route::get('/formularios', [SocioController::class, 'formulariosSocio'])->name('formularios');
    });

    /* --------------------------------------------------------------------------
       AREA DE ADMINISTRADOR (Tipo 2)
    -------------------------------------------------------------------------- */
    Route::prefix('admin')->name('admin.')->group(function () {

        // Dashboard Principal
        Route::get('/', [SocioController::class, 'adminDashboard'])->name('dashboard');

        // Gestión de Socios y Préstamos
        Route::resource('socios', SocioController::class);
        Route::resource('prestamos', PrestamoController::class);
        Route::patch('/socios/{socio}/toggle-status', [SocioController::class, 'toggleStatus'])->name('socios.toggle_status');
        Route::get('socios/{socio}/prestamos/historial-pagados', [SocioController::class, 'showHistorialPrestamos'])->name('socios.historial.prestamos');

        // Gestión de Solicitudes Digitales
        Route::get('/solicitudes', [SolicitudController::class, 'indexAdmin'])->name('solicitudes.index');

        // Caja y Ahorros
        Route::get('/prestamos/{prestamo}/pagar', [PagoController::class, 'create'])->name('pagos.create');
        Route::post('/prestamos/{prestamo}/pagar', [PagoController::class, 'store'])->name('pagos.store');
        Route::put('/cuentas/update-cuota/{id}', [SocioController::class, 'updateCuota'])->name('cuentas.update_cuota');
        Route::post('/ahorros/transaccion', [SocioController::class, 'storeTransaction'])->name('ahorros.transaction.store');
        Route::put('/ahorros/transaccion/{id}', [SocioController::class, 'updateTransaction'])->name('ahorros.transaction.update');
        Route::delete('/ahorros/transaccion/{id}', [SocioController::class, 'destroyTransaction'])->name('ahorros.transaction.destroy');

        // Reportes e Inteligencia
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

        // Exportación de Nómina
        Route::get('/exportar-nomina/{tipo}', function ($tipo) {
            $nombre = "Nomina_" . ucfirst($tipo) . "_" . now()->format('m_Y') . ".xlsx";
            return Excel::download(new NominaExport($tipo), $nombre);
        })->name('reportes.nomina');

        Route::get('/mi-perfil', [SocioController::class, 'miPerfilSocio'])->name('perfil.propio');
        // ESTA ES LA LÍNEA QUE DEBES AGREGAR:
Route::get('/solicitudes/{id}', [SolicitudController::class, 'showAdmin'])->name('solicitudes.show');
// Dentro de Route::prefix('admin')->name('admin.')->group(function () { ...

Route::patch('/solicitudes/{id}/estado', [SolicitudController::class, 'updateEstado'])->name('solicitudes.estado');
Route::get('/solicitudes/{id}/descargar', [SolicitudController::class, 'descargarPdf'])->name('solicitudes.descargar');
    });
// Cambiamos el controlador a SocioController y el método a destroyUser
Route::delete('/admin/socios/limpiar-usuario/{id}', [App\Http\Controllers\SocioController::class, 'destroyUser'])->name('admin.socios.limpiar');

});
