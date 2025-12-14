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
    public function socio()
{
    return $this->hasOne(Socio::class);
}
}
