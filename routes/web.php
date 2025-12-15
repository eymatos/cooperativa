<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\AhorroController;
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


/* --------------------------------------------------------------------------
   AREA DE ADMINISTRADOR (Tipo 2)
-------------------------------------------------------------------------- */
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // 1. GESTIÓN DE SOCIOS (Corregido: Ya no está anidado doblemente)
    Route::resource('socios', SocioController::class);

    // 2. GESTIÓN DE PRÉSTAMOS
    Route::resource('prestamos', PrestamoController::class);

    // 3. CAJA (Registrar Pagos)
    Route::get('/prestamos/{prestamo}/pagar', [PagoController::class, 'create'])->name('pagos.create');
    Route::post('/prestamos/{prestamo}/pagar', [PagoController::class, 'store'])->name('pagos.store');

});
