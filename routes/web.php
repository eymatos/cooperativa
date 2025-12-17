<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\AhorroController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\SocioController; // <--- IMPRESCINDIBLE

/* --------------------------------------------------------------------------
   RUTAS PÚBLICAS (Login / Logout)
-------------------------------------------------------------------------- */

Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de Autenticación
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/* --------------------------------------------------------------------------
   RUTAS GENERALES (Para usuarios logueados)
-------------------------------------------------------------------------- */
Route::middleware('auth')->group(function () {

    // 1. EL "SEMÁFORO" (Dashboard Redirect)
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->tipo == 2) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('socio.dashboard');
    })->name('dashboard');


    // 2. UTILIDADES (Simulación de Préstamo - AJAX)
    Route::post('prestamos/simular', [PrestamoController::class, 'simular'])->name('prestamos.simular');
});

Route::middleware(['auth', \App\Http\Middleware\LogUserVisit::class])->group(function () {

    /* Aquí dentro van tus grupos actuales de:
       - AREA DE SOCIOS
       - AREA DE ADMINISTRADOR
    */


/* --------------------------------------------------------------------------
   AREA DE SOCIOS (Tipo 0)
-------------------------------------------------------------------------- */
Route::middleware('auth')->prefix('socio')->group(function () {

    // Dashboard Socio
    Route::get('/', function () {
        return view('socio.dashboard');
    })->name('socio.dashboard');

    // Módulos de Lectura
    Route::get('/mis-ahorros', [AhorroController::class, 'index'])->name('ahorros.index');
    Route::get('/mis-ahorros/{id}', [AhorroController::class, 'show'])->name('ahorros.show');

    Route::get('/mis-prestamos', [PrestamoController::class, 'misPrestamos'])->name('prestamos.mis_prestamos');
    Route::get('/mis-prestamos/{prestamo}', [PrestamoController::class, 'show'])->name('prestamos.show_socio');
});
});

/* --------------------------------------------------------------------------
   AREA DE ADMINISTRADOR (Tipo 2)
-------------------------------------------------------------------------- */
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    // Ahora apuntamos al método que procesa los datos financieros
    Route::get('/', [SocioController::class, 'adminDashboard'])->name('dashboard');

    // 1. GESTIÓN DE SOCIOS
    Route::resource('socios', SocioController::class);

    // NUEVA RUTA: Historial de Préstamos Pagados (LIMPIA)
    Route::get('socios/{socio}/prestamos/historial-pagados', [SocioController::class, 'showHistorialPrestamos'])
        ->name('socios.historial.prestamos');

    // 2. GESTIÓN DE PRÉSTAMOS
    Route::resource('prestamos', PrestamoController::class);

    // 3. CAJA
    Route::get('/prestamos/{prestamo}/pagar', [PagoController::class, 'create'])->name('pagos.create');
    Route::post('/prestamos/{prestamo}/pagar', [PagoController::class, 'store'])->name('pagos.store');

    // ACTUALIZAR CUOTA DE AHORRO
    Route::put('/cuentas/update-cuota/{id}', [SocioController::class, 'updateCuota'])->name('cuentas.update_cuota');
    // --- GESTIÓN DE TRANSACCIONES DE AHORRO (Correcciones) ---
    Route::post('/ahorros/transaccion', [SocioController::class, 'storeTransaction'])->name('ahorros.transaction.store');
    Route::put('/ahorros/transaccion/{id}', [SocioController::class, 'updateTransaction'])->name('ahorros.transaction.update');
    // Ruta para eliminar (opcional pero útil para correcciones)
    Route::delete('/ahorros/transaccion/{id}', [SocioController::class, 'destroyTransaction'])->name('ahorros.transaction.destroy');
    Route::patch('/socios/{socio}/toggle-status', [SocioController::class, 'toggleStatus'])->name('socios.toggle_status');
    Route::get('/vencimientos-prestamos', [PrestamoController::class, 'reporteVencimientos'])->name('prestamos.vencimientos');
    // Reporte de visitas y estadísticas de socios
    Route::get('/reportes-visitas', [SocioController::class, 'estadisticasVisitas'])->name('reportes.visitas');
    Route::get('/mi-perfil', [SocioController::class, 'miPerfilSocio'])->name('perfil.propio');
    Route::get('/reportes/morosidad', [PrestamoController::class, 'reporteMorosidad'])->name('reportes.morosidad');
    Route::get('/reportes/auditoria', [App\Http\Controllers\Admin\ReporteController::class, 'auditoria'])
        ->name('reportes.auditoria');
    Route::get('/reportes/utilidades', [ReporteController::class, 'utilidades'])->name('reportes.utilidades');
    Route::get('/reportes/proyeccion', [ReporteController::class, 'proyeccion'])->name('reportes.proyeccion');
    Route::get('/reportes/concentracion', [ReporteController::class, 'concentracion'])->name('reportes.concentracion');
    Route::get('/reportes/ahorros-pasivos', [ReporteController::class, 'ahorrosPasivos'])->name('reportes.ahorros');
});
