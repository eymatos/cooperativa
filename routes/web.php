<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\PagoController;

Route::get('/', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return 'Dashboard del sistema';
})->middleware('auth')->name('dashboard');
Route::middleware('auth')->group(function () {

    Route::get('/socio', function () {
        return view('socio.dashboard'); // Antes decía: return 'Dashboard SOCIO';
    })->name('socio.dashboard');

    Route::get('/soporte', function () {
        return 'Dashboard SOPORTE';
    })->name('soporte.dashboard');

    Route::get('/admin', function () {
        return 'Dashboard ADMIN';
    })->name('admin.dashboard');
    Route::resource('prestamos', PrestamoController::class);
    Route::get('/prestamos/{prestamo}/pagar', [PagoController::class, 'create'])->name('pagos.create');
    Route::post('/prestamos/{prestamo}/pagar', [PagoController::class, 'store'])->name('pagos.store');
});
