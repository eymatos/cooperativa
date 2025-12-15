<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- 1. IMPORTANTE PARA SEEDERS
use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    use HasFactory; // <--- 2. AGREGA ESTO

    protected $fillable = [
        'user_id',
        'nombres',
        'apellidos',
        'telefono',
        'direccion',
        'ahorro_total',
        // --- AGREGA ESTOS CAMPOS ÚTILES PARA PRÉSTAMOS ---
        'sueldo',        // Para saber capacidad de pago
        'lugar_trabajo', // Para saber riesgo
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
    public function cuentas()
    {
        return $this->hasMany(SavingsAccount::class);
    }
}
