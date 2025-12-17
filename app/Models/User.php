<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',    // Añadimos esto
        'email',   // Añadimos esto
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
    /**
 * Accesor: Cada vez que hagas $user->cedula, se mostrará con guiones.
 */

protected function cedula(): Attribute
{
    return Attribute::make(
        // Al leer de la BD: Ponemos guiones
        get: function ($value) {
            $limpia = str_replace('-', '', $value);
            if (strlen($limpia) !== 11) return $value;
            return substr($limpia, 0, 3) . '-' . substr($limpia, 3, 7) . '-' . substr($limpia, 10, 1);
        },
        // Al escribir en la BD: Quitamos guiones
        set: fn ($value) => str_replace('-', '', $value),
    );
}
/**
 * Indica a Laravel qué campo mostrar cuando se busca una representación
 * de texto del usuario (opcional, pero ayuda a la claridad).
 */
public function getRouteKeyName()
{
    return 'id'; // O 'cedula' si prefieres, pero esto asegura consistencia
}
}
