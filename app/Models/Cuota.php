<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    protected $fillable = [
        'prestamo_id',
        'numero_cuota',
        'capital',
        'interes',
        'monto_total',
        'fecha_vencimiento',
        'pagado',
        'estado'
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }
}
