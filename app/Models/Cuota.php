<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    use HasFactory;

    protected $fillable = [
        'prestamo_id',
        'numero_cuota',
        'fecha_vencimiento',
        'monto_total',
        'interes',
        'capital',
        'saldo_restante', // Este es el saldo del PRÉSTAMO
        'abonado',        // <--- NUEVO: Este es el saldo pagado de la CUOTA
        'estado'
    ];
}
