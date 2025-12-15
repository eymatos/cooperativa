<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'cedula',
        'password',
        'tipo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
// Relación 1: Un Usuario tiene un Perfil de Socio
    public function socio()
    {
        return $this->hasOne(Socio::class);
    }

    // Relación 2: Un Usuario tiene muchos Préstamos (A través de su perfil de Socio)
    public function prestamos()
    {
        // "HasManyThrough" significa: El Usuario tiene Préstamos... a través de la tabla Socios
        return $this->hasManyThrough(Prestamo::class, Socio::class);
    }

}
