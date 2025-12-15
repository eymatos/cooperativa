<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsTransaction extends Model
{
    protected $fillable = ['savings_account_id', 'type', 'amount', 'date', 'description'];

    // ✅ TRUCO DE LARAVEL: 'Casting'
    // Al poner esto, Laravel convierte automáticamente la fecha en un objeto Carbon.
    // Nos permite hacer cosas como $tx->date->month en el controlador fácilmente.
    protected $casts = [
        'date' => 'date',
    ];

    public function account()
    {
        return $this->belongsTo(SavingsAccount::class, 'savings_account_id');
    }
}
