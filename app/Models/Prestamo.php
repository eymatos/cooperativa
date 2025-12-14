<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $fillable = [
        'socio_id',
        'monto',
        'tasa_interes',
        'plazo',
        'saldo_capital',
        'fecha_solicitud',
        'fecha_inicio',
        'estado'
    ];

    // Un préstamo pertenece a un Socio
    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }

    // Un préstamo tiene muchas cuotas
    public function cuotas()
    {
        return $this->hasMany(Cuota::class);
    }
}
