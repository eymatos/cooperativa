<?php

namespace App\Exports;

use App\Models\Socio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class NominaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    protected $tipo;
    protected $rowNumber = 0;
    protected $rosado = 'FFFFD9E1';

    public function __construct($tipo) {
        $this->tipo = $tipo;
    }

    public function collection()
{
    // Definimos el límite de 31 días atrás
    $fechaLimiteInactivos = \Carbon\Carbon::now()->subDays(31);

    return Socio::with(['user', 'cuentas.type', 'prestamos.cuotas'])
        ->where('tipo_contrato', $this->tipo) // Filtra Fijo o Contratado
        ->where(function ($query) use ($fechaLimiteInactivos) {
            $query->where('activo', 1) // REGLA 1: Si está activo, aparece SIEMPRE
                  ->orWhere(function ($q) use ($fechaLimiteInactivos) {
                      // REGLA 2: Si está inactivo (0), solo aparece si su fecha
                      // de desactivación es menor a 31 días
                      $q->where('activo', 0)
                        ->where('updated_at', '>=', $fechaLimiteInactivos);
                  });
        })
        ->orderBy('id', 'asc')
        ->get();
}

    public function headings(): array {
        $mesAnio = Carbon::now()->translatedFormat('F Y');
        return [
            ['Descuentos Cooprocon Empleados ' . ucfirst($this->tipo) . ' ' . $mesAnio],
            ['No.', 'Nombre y apellido', 'Cédula', 'inscripción', 'Aporte a Capital', 'Ahorro', 'Ahorro retirable', 'Préstamo normal', 'Préstamo útiles escolares', 'Préstamo educativo', 'Préstamo Express', 'Préstamo vacacional', 'Total Ahorros', 'Total Préstamos', 'Total Descuentos']
        ];
    }

    public function map($socio): array {
        $this->rowNumber++;
        $esNuevo = $socio->created_at->isCurrentMonth();

        // Limpieza de datos (Null coalescing to zero)
        $inscripcion = (float)($esNuevo ? 200.00 : 0.00);
        $aporte = (float)($esNuevo ? 250.00 : 0.00);

        $ahorroNormal = 0.00;
        $ahorroRetirable = 0.00;

        foreach ($socio->cuentas as $cuenta) {
            $monto = floatval($cuenta->recurring_amount);
            if ($cuenta->type && in_array($cuenta->type->code, ['APO', 'aportacion'])) {
                $ahorroNormal = $monto;
            }
            if ($cuenta->type && in_array($cuenta->type->code, ['RET', 'voluntario'])) {
                $ahorroRetirable = $monto;
            }
        }

        $pNormal = 0.00; $pUtiles = 0.00; $pEdu = 0.00; $pVac = 0.00; $pExp = 0.00;
        foreach ($socio->prestamos as $prestamo) {
            $cuota = $prestamo->cuotas->where('estado', 'pendiente')->first();
            if ($cuota) {
                $montoCuota = floatval($cuota->capital) + floatval($cuota->interes);
                switch ($prestamo->tipo_prestamo_id) {
                    case 1: $pNormal += $montoCuota; break;
                    case 2: $pUtiles += $montoCuota; break;
                    case 3: $pEdu += $montoCuota; break;
                    case 4: $pVac += $montoCuota; break;
                    case 5: $pExp += $montoCuota; break;
                }
            }
        }

        $totalAhorros = $ahorroNormal + $ahorroRetirable;
        $totalPrestamos = $pNormal + $pUtiles + $pEdu + $pExp;
        $totalDescuentos = $inscripcion + $aporte + $totalAhorros + $totalPrestamos + $pVac;

        // TRUCO FINAL: Si el valor es 0, lo enviamos como el string "0.00"
        // para que Excel no lo oculte como celda vacía.
        $formatear = function($valor) {
            return $valor == 0 ? "0.00" : (float)$valor;
        };

        return [
            $this->rowNumber,
            mb_strtoupper($socio->nombres . ' ' . $socio->apellidos),
            $socio->user->cedula,
            $formatear($inscripcion),
            $formatear($aporte),
            $formatear($ahorroNormal),
            $formatear($ahorroRetirable),
            $formatear($pNormal),
            $formatear($pUtiles),
            $formatear($pEdu),
            $formatear($pExp),
            $formatear($pVac),
            $formatear($totalAhorros),
            $formatear($totalPrestamos),
            $formatear($totalDescuentos)
        ];
    }

    public function columnFormats(): array {
        // Formato numérico estándar con dos decimales
        return [
            'D:O' => '0.00',
        ];
    }

    public function styles(Worksheet $sheet) {
    $sheet->mergeCells('A1:O1');
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A1:O2')->getFont()->setBold(true);
    $sheet->getStyle('A2:O2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');

    $socios = $this->collection();
    $mesActual = Carbon::now()->format('Y-m');

    foreach ($socios as $index => $socio) {
        $fila = $index + 3;

        // A. FILA COMPLETA: Solo si el socio es nuevo o está inactivo
        if ($socio->created_at->format('Y-m') === $mesActual || !$socio->activo) {
            $sheet->getStyle("A{$fila}:O{$fila}")->getFill()
                ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($this->rosado);
            continue;
        }

        // B. CELDAS DE PRÉSTAMOS: Solo si el préstamo se creó este mes
        foreach ($socio->prestamos as $prestamo) {
            if ($prestamo->created_at->format('Y-m') === $mesActual) {
                $col = match($prestamo->tipo_prestamo_id) {
                    1 => 'H', 2 => 'I', 3 => 'J', 5 => 'K', 4 => 'L', default => null
                };
                if ($col) {
                    $sheet->getStyle("{$col}{$fila}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($this->rosado);
                }
            }
        }

        // C. CELDAS DE AHORRO: Solo si se modificaron este mes
        foreach ($socio->cuentas as $cuenta) {
            if ($cuenta->updated_at->format('Y-m') === $mesActual) {
                $colAhorro = null;
                if (in_array($cuenta->type->code, ['APO', 'aportacion'])) $colAhorro = 'F';
                if (in_array($cuenta->type->code, ['RET', 'voluntario'])) $colAhorro = 'G';

                if ($colAhorro) {
                    $sheet->getStyle("{$colAhorro}{$fila}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($this->rosado);
                }
            }
        }
    }
}
}
