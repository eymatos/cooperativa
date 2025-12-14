<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'prestamo_id', 'user_id', 'monto',
        'fecha_pago', 'referencia', 'metodo', 'nota'
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }
}
