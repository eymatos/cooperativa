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
        'monto_total',      // Total de la cuota (obligatorio en tu DB)
        'pagado',           // Duplicado del total (usado en tu DB)
        'interes',
        'capital',
        'saldo_restante',   // Saldo del préstamo tras este pago
        'abonado',          // Monto parcial pagado
        'estado'
    ];

    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class, 'prestamo_id');
    }

    protected $casts = [
        'capital' => 'decimal:2',
        'interes' => 'decimal:2',
        'monto_total' => 'decimal:2',
        'pagado' => 'decimal:2',
        'saldo_restante' => 'decimal:2',
        'abonado' => 'decimal:2',
    ];
}
