<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; // <--- IMPORTANTE: Importar Schedule

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Programación de la Nómina Automática
 * Se ejecuta el día 19 de cada mes a las 08:00
 */
Schedule::command('nomina:ejecutar')->monthlyOn(19, '08:00');
