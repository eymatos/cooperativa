<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    protected $fillable = [
        'user_id',
        'nombres',
        'apellidos',
        'telefono',
        'direccion',
        'ahorro_total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}
