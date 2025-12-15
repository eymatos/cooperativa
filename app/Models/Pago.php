<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'prestamo_id',
        'user_id', // <--- AGREGAR ESTO (El cajero/admin que cobra)
        'monto',
        'fecha_pago',
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    // Relación con el usuario que registró el pago (El Admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
