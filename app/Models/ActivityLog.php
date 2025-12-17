<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    // Autorizamos los campos para que Laravel permita el insert
    protected $fillable = [
        'user_id',
        'action',
        'model',
        'model_id',
        'before',
        'after',
        'ip_address'
    ];

    // Es buena práctica indicar que estos campos son JSON
    protected $casts = [
        'before' => 'array',
        'after' => 'array',
    ];

    /**
     * Relación: Un log pertenece a un usuario (el que hizo la acción)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
