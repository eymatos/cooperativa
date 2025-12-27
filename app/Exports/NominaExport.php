<?php

namespace App\Exports;

use App\Models\Socio;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class NominaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnFormatting, WithEvents
{
    protected $tipo;
    protected $rowNumber = 0;
    protected $rosado = 'FFFFD9E1';
    protected $inicioVentana;
    protected $finVentana;
    protected $totalRows = 0;

    public function __construct($tipo) {
        $this->tipo = $tipo;
        $hoy = Carbon::now();

        if ($hoy->day >= 18) {
            $this->inicioVentana = Carbon::now()->day(25)->startOfDay();
            $this->finVentana = Carbon::now()->addMonth()->day(17)->endOfDay();
        } else {
            $this->inicioVentana = Carbon::now()->subMonth()->day(25)->startOfDay();
            $this->finVentana = Carbon::now()->day(17)->endOfDay();
        }
    }

    public function collection() {
        $coleccion = Socio::with(['user', 'cuentas.type', 'prestamos.cuotas'])
            ->where('tipo_contrato', $this->tipo)
            ->where(function ($query) {
                $query->where('activo', 1)
                      ->orWhere(function ($q) {
                          $q->where('activo', 0)
                            ->where('updated_at', '>=', $this->inicioVentana);
                      });
            })
            ->orderBy('nombres', 'asc')
            ->get();

        $this->totalRows = $coleccion->count();
        return $coleccion;
    }

    public function headings(): array {
        $mesCobro = Carbon::now()->addMonth()->translatedFormat('F Y');
        return [
            ['Descuentos Cooprocon Empleados ' . ucfirst($this->tipo) . ' - Cobro en ' . $mesCobro],
            ['No.', 'Nombre y apellido', 'Cédula', 'Insc.', 'Aporte Cap.', 'Ahorro', 'Retirable', 'P. Normal', 'P. Útiles', 'P. Edu.', 'P. Express', 'P. Vac.', 'Tot. Ahorro', 'Tot. Prést.', 'TOTAL']
        ];
    }

    public function map($socio): array {
        $this->rowNumber++;

        $fechaSocio = $socio->created_at ? Carbon::parse($socio->created_at) : Carbon::now();
        $esNuevo = $fechaSocio->between($this->inicioVentana, $this->finVentana);

        $inscripcion = (float)($esNuevo ? 200.00 : 0.00);
        $aporte = (float)($esNuevo ? 250.00 : 0.00);

        $ahorroNormal = 0.00;
        $ahorroRetirable = 0.00;

        if ($socio->cuentas) {
            foreach ($socio->cuentas as $cuenta) {
                $monto = (float)($cuenta->recurring_amount ?? 0);
                if ($cuenta->type) {
                    $codigo = strtoupper($cuenta->type->code);
                    if (in_array($codigo, ['APO', 'APORTACION'])) $ahorroNormal = $monto;
                    if (in_array($codigo, ['RET', 'VOLUNTARIO'])) $ahorroRetirable = $monto;
                }
            }
        }

        $p = [1=>0, 2=>0, 3=>0, 4=>0, 5=>0];
        if ($socio->prestamos) {
            foreach ($socio->prestamos as $prestamo) {
                if ($prestamo->estado === 'activo') {
                    $cuota = $prestamo->cuotas->where('estado', 'pendiente')->first();
                    if ($cuota) {
                        $montoCuota = (float)($cuota->capital ?? 0) + (float)($cuota->interes ?? 0);
                        if (array_key_exists($prestamo->tipo_prestamo_id, $p)) {
                            $p[$prestamo->tipo_prestamo_id] += $montoCuota;
                        }
                    }
                }
            }
        }

        return [
            $this->rowNumber,
            mb_strtoupper(($socio->nombres ?? 'S/N') . ' ' . ($socio->apellidos ?? '')),
            $socio->user->cedula ?? 'S/C',
            (float)$inscripcion,
            (float)$aporte,
            (float)$ahorroNormal,
            (float)$ahorroRetirable,
            (float)$p[1], (float)$p[2], (float)$p[3], (float)$p[5], (float)$p[4],
            (float)($ahorroNormal + $ahorroRetirable),
            (float)array_sum($p),
            (float)($inscripcion + $aporte + $ahorroNormal + $ahorroRetirable + array_sum($p))
        ];
    }

    public function columnFormats(): array {
        return ['D:O' => '#,##0.00'];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $this->totalRows + 2;
                $sumRow = $lastRow + 1;

                // CONFIGURACIÓN DE ANCHOS COMPACTOS
                $sheet->getColumnDimension('A')->setWidth(5);   // No.
                $sheet->getColumnDimension('B')->setWidth(30);  // Nombre
                $sheet->getColumnDimension('C')->setWidth(15);  // Cédula

                // Columnas numéricas (D hasta O) con ancho estrecho
                foreach (range('D', 'O') as $col) {
                    $sheet->getColumnDimension($col)->setWidth(11);
                }

                // Ajuste de texto en encabezados para que no ensanchen la columna
                $sheet->getStyle('A2:O2')->getAlignment()->setWrapText(true);
                $sheet->getRowDimension(2)->setRowHeight(35); // Altura doble para encabezados

                // SUMATORIAS
                $sheet->setCellValue("B{$sumRow}", 'TOTALES GENERALES:');
                $columns = ['D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O'];
                foreach ($columns as $col) {
                    $sheet->setCellValue("{$col}{$sumRow}", "=SUM({$col}3:{$col}{$lastRow})");
                }

                // Estilos para la fila de totales
                $sheet->getStyle("A{$sumRow}:O{$sumRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFCCFFCC'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    ],
                ]);
            },
        ];
    }

    public function styles(Worksheet $sheet) {
        $sheet->mergeCells('A1:O1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:O2')->getFont()->setBold(true);
        $sheet->getStyle('A2:O2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');
        $sheet->getStyle('A2:O2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2:O2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $socios = $this->collection();

        foreach ($socios as $index => $socio) {
            $fila = $index + 3;

            // Centrar columnas numéricas para que se vea más limpio el ancho compacto
            $sheet->getStyle("D{$fila}:O{$fila}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $fCreacion = $socio->created_at ? Carbon::parse($socio->created_at) : null;
            $fUpdate = $socio->updated_at ? Carbon::parse($socio->updated_at) : null;

            $filaRosada = false;
            if ($fCreacion && $fCreacion->between($this->inicioVentana, $this->finVentana)) $filaRosada = true;
            if (!$socio->activo && $fUpdate && $fUpdate->between($this->inicioVentana, $this->finVentana)) $filaRosada = true;

            if ($filaRosada) {
                $sheet->getStyle("A{$fila}:O{$fila}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($this->rosado);
                continue;
            }

            // ... (Resto de la lógica de colores de préstamos y ahorros se mantiene igual)
            if ($socio->prestamos) {
                foreach ($socio->prestamos as $prestamo) {
                    $pCreacion = $prestamo->created_at ? Carbon::parse($prestamo->created_at) : null;
                    $pUpdate = $prestamo->updated_at ? Carbon::parse($prestamo->updated_at) : null;
                    if (($pCreacion && $pCreacion->between($this->inicioVentana, $this->finVentana)) ||
                        ($prestamo->estado === 'pagado' && $pUpdate && $pUpdate->between($this->inicioVentana, $this->finVentana))) {
                        $col = match((int)$prestamo->tipo_prestamo_id) {
                            1 => 'H', 2 => 'I', 3 => 'J', 5 => 'K', 4 => 'L', default => null
                        };
                        if ($col) {
                            $sheet->getStyle("{$col}{$fila}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($this->rosado);
                        }
                    }
                }
            }

            if ($socio->cuentas) {
                foreach ($socio->cuentas as $cuenta) {
                    $fManual = $cuenta->manual_change_at ? Carbon::parse($cuenta->manual_change_at) : null;
                    if ($fManual && $fManual->between($this->inicioVentana, $this->finVentana)) {
                        $codigo = strtoupper($cuenta->type->code ?? '');
                        $colAhorro = match($codigo) {
                            'APO', 'APORTACION' => 'F', 'RET', 'VOLUNTARIO' => 'G', default => null
                        };
                        if ($colAhorro) {
                            $sheet->getStyle("{$colAhorro}{$fila}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($this->rosado);
                        }
                    }
                }
            }
        }
    }
}
