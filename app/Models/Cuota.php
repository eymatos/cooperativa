<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public function prestamo(): BelongsTo
    {
        // Asegúrate de que el nombre de la columna en la DB sea prestamo_id
        return $this->belongsTo(Prestamo::class, 'prestamo_id');
    }
}
