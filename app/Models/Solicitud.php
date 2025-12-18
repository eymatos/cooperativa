<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Solicitud extends Model
{
    // Definimos el nombre de la tabla por seguridad
    protected $table = 'solicitudes';

    // Campos que permitimos llenar
    protected $fillable = [
        'user_id',
        'tipo',
        'datos',
        'estado',
        'comentarios_admin'
    ];

    // IMPORTANTE: Esto convierte el JSON de la base de datos en un array de PHP automáticamente
    protected $casts = [
        'datos' => 'array',
    ];

    // Relación: Una solicitud pertenece a un usuario (si ya está registrado)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
