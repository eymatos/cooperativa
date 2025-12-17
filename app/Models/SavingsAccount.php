<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsAccount extends Model
{
    // ✅ Agregamos 'recurring_amount' a la lista permitida
    protected $fillable = ['socio_id', 'saving_type_id', 'balance', 'recurring_amount'];

    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }

    public function type()
    {
        return $this->belongsTo(SavingType::class, 'saving_type_id');
    }

    public function transactions()
    {
        return $this->hasMany(SavingsTransaction::class);
    }

    protected $casts = [
        'recurring_amount' => 'decimal:2',
    ];
}
