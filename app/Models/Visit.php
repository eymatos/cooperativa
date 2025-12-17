<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    // AÑADE ESTA LÍNEA EXACTAMENTE:
    protected $fillable = ['user_id', 'ip_address', 'user_agent', 'url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
