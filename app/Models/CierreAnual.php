<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CierreAnual extends Model
{
    protected $fillable = [
        'anio', 'excedente_bruto', 'reserva_legal',
        'reserva_educacion', 'excedente_neto',
        'pct_capitalizacion', 'pct_patrocinio', 'user_id'
    ];
}
