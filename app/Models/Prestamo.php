<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'socio_id',
        'tipo_prestamo_id',
        'numero_prestamo', // <--- AGREGAR ESTO
        'monto',
        'tasa_interes',
        'plazo',
        'saldo_capital',
        'fecha_solicitud',
        'fecha_inicio',
        'estado'
    ];

    // Relación con el Socio
    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }

    // Relación con las Cuotas
    public function cuotas()
    {
        return $this->hasMany(Cuota::class);
    }

    // ✅ NUEVA RELACIÓN: Un Préstamo pertenece a un Tipo de Préstamo
    public function tipoPrestamo()
    {
        return $this->belongsTo(TipoPrestamo::class);
    }
}
