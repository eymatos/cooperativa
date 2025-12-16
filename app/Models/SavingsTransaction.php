<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'savings_account_id',
        'type', // deposit, withdrawal, interest
        'amount',
        'date',
        'description',
    ];

    // ESTA ES LA PARTE CLAVE QUE FALTA
    // Le dice a Laravel: "El campo 'date' es una fecha real, no solo texto"
    protected $casts = [
        'date' => 'datetime',
        'amount' => 'decimal:2'
    ];

    // Relación inversa (opcional pero recomendada)
    public function account()
    {
        return $this->belongsTo(SavingsAccount::class, 'savings_account_id');
    }
}
