<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingType extends Model
{
    // Permitimos llenar estos campos masivamente
    protected $fillable = ['name', 'code', 'allow_withdrawals'];

    // Relación: Un Tipo de Ahorro tiene muchas Cuentas asociadas
    public function accounts()
    {
        return $this->hasMany(SavingsAccount::class);
    }
}
