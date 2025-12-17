<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Prestamo;
use App\Models\SavingsAccount; // 1. Importa el modelo
use App\Observers\PrestamoObserver;
use App\Observers\SavingsAccountObserver; // 2. Importará el nuevo Observer

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Prestamo::observe(PrestamoObserver::class);

        // 3. Registra el observador de ahorros
        SavingsAccount::observe(SavingsAccountObserver::class);
        \App\Models\Socio::observe(\App\Observers\SocioObserver::class);
    }
}
