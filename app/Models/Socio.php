<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Prestamo; // <--- ¡AÑADE ESTA LÍNEA!
use App\Models\SavingsAccount; // Asumo que esta clase es necesaria
// Asegúrate de que las demás clases que uses también estén aquí.

class Socio extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'nombres',
    'apellidos',
    'telefono',
    'direccion',
    'sueldo',
    'lugar_trabajo',
    'tipo_contrato', // <--- DEBE ESTAR AQUÍ
    'ahorro_total',
    'salario',
    'activo'
];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor para obtener la cédula
    public function getCedulaAttribute()
    {
        return $this->user->cedula ?? 'Sin Cédula';
    }

    // Relación con los préstamos (Ahora Prestamo está correctamente importado)
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'socio_id');
    }

    // Relación con las cuentas de ahorro
    public function cuentas()
    {
        return $this->hasMany(SavingsAccount::class);
    }
    public function cuotas()
{
    return $this->hasManyThrough(
        \App\Models\Cuota::class,
        \App\Models\Prestamo::class,
        'socio_id',      // Clave foránea en tabla Prestamos
        'prestamo_id',   // Clave foránea en tabla Cuotas
        'id',            // Clave local en tabla Socios
        'id'             // Clave local en tabla Prestamos
    );
}
}
