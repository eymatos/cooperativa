<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastoAdministrativo extends Model
{
    use HasFactory;

    protected $table = 'gasto_administrativos';

    protected $fillable = [
        'descripcion',
        'monto',
        'fecha',
        'categoria'
    ];

    // Para asegurar que la fecha se maneje siempre como un objeto de fecha
    protected $casts = [
        'fecha' => 'date',
        'monto' => 'decimal:2'
    ];

    // Constantes para las categorías (ayuda a evitar errores de dedo)
    const CAT_BANCARIO = 'bancario';
    const CAT_NOMINA = 'nomina';
    const CAT_WEB = 'servicios_web';
    const CAT_REDES = 'redes_sociales';
    const CAT_COMIDA = 'comida_eventos';
    const CAT_RIFAS = 'rifas_navidad';
    const CAT_INCENTIVOS = 'incentivos_directivos';
    const CAT_OTROS = 'otros';

    // Función para obtener las categorías de forma legible en la vista
    public static function getCategorias()
    {
        return [
            self::CAT_BANCARIO => 'Gastos Bancarios',
            self::CAT_NOMINA => 'Pago de Nómina',
            self::CAT_WEB => 'Servicios Web / Hosting',
            self::CAT_REDES => 'Redes Sociales',
            self::CAT_COMIDA => 'Comida y Eventos (Meriendas)',
            self::CAT_RIFAS => 'Rifas de Navidad',
            self::CAT_INCENTIVOS => 'Incentivos Directivos',
            self::CAT_OTROS => 'Otros Gastos',
        ];
    }
}
