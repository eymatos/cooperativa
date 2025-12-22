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
    protected $inicioVentana;
    protected $finVentana;

    public function __construct($tipo) {
        $this->tipo = $tipo;

        $hoy = Carbon::now();

        /**
         * LÓGICA DE VENTANA DE NOVEDADES (25 al 17):
         * Los cambios son "novedad" desde el 25 del mes anterior hasta el 17 del mes actual.
         * Si hoy es 21 de Dic (ya pasó el 17), la ventana actual apunta al futuro:
         * Inicio: 25 de Diciembre / Fin: 17 de Enero.
         */
        if ($hoy->day >= 18) {
            $this->inicioVentana = Carbon::now()->day(25)->startOfDay();
            $this->finVentana = Carbon::now()->addMonth()->day(17)->endOfDay();
        } else {
            $this->inicioVentana = Carbon::now()->subMonth()->day(25)->startOfDay();
            $this->finVentana = Carbon::now()->day(17)->endOfDay();
        }
    }

    public function collection() {
        return Socio::with(['user', 'cuentas.type', 'prestamos.cuotas'])
            ->where('tipo_contrato', $this->tipo)
            ->where(function ($query) {
                $query->where('activo', 1)
                      ->orWhere(function ($q) {
                          // Salidas de socios dentro de la ventana de visibilidad
                          $q->where('activo', 0)
                            ->where('updated_at', '>=', $this->inicioVentana);
                      });
            })
            ->orderBy('nombres', 'asc')
            ->get();
    }

    public function headings(): array {
        // Determinamos el mes de cobro (Enero si estamos en Diciembre)
        $mesCobro = Carbon::now()->addMonth()->translatedFormat('F Y');
        return [
            ['Descuentos Cooprocon Empleados ' . ucfirst($this->tipo) . ' - Cobro en ' . $mesCobro],
            ['No.', 'Nombre y apellido', 'Cédula', 'inscripción', 'Aporte a Capital', 'Ahorro', 'Ahorro retirable', 'Préstamo normal', 'Préstamo útiles escolares', 'Préstamo educativo', 'Préstamo Express', 'Préstamo vacacional', 'Total Ahorros', 'Total Préstamos', 'Total Descuentos']
        ];
    }

    public function map($socio): array {
        $this->rowNumber++;

        // Es nuevo si su created_at cae dentro de la ventana activa
        $esNuevo = $socio->created_at->between($this->inicioVentana, $this->finVentana);

        $inscripcion = (float)($esNuevo ? 200.00 : 0.00);
        $aporte = (float)($esNuevo ? 250.00 : 0.00);

        $ahorroNormal = 0.00;
        $ahorroRetirable = 0.00;

        foreach ($socio->cuentas as $cuenta) {
            $monto = (float)($cuenta->recurring_amount ?? 0);
            if ($cuenta->type) {
                $codigo = strtoupper($cuenta->type->code);
                if (in_array($codigo, ['APO', 'APORTACION'])) $ahorroNormal = $monto;
                if (in_array($codigo, ['RET', 'VOLUNTARIO'])) $ahorroRetirable = $monto;
            }
        }

        $p = [1=>0, 2=>0, 3=>0, 4=>0, 5=>0];
        foreach ($socio->prestamos as $prestamo) {
            if ($prestamo->estado === 'activo') {
                $cuota = $prestamo->cuotas->where('estado', 'pendiente')->first();
                if ($cuota) {
                    $montoCuota = (float)($cuota->capital ?? 0) + (float)($cuota->interes ?? 0);
                    if (isset($p[$prestamo->tipo_prestamo_id])) $p[$prestamo->tipo_prestamo_id] += $montoCuota;
                }
            }
        }

        $formatear = fn($v) => $v == 0 ? "0.00" : (float)$v;

        return [
            $this->rowNumber,
            mb_strtoupper(($socio->nombres ?? '') . ' ' . ($socio->apellidos ?? '')),
            $socio->user->cedula ?? 'S/C',
            $formatear($inscripcion),
            $formatear($aporte),
            $formatear($ahorroNormal),
            $formatear($ahorroRetirable),
            $formatear($p[1]), $formatear($p[2]), $formatear($p[3]), $formatear($p[5]), $formatear($p[4]),
            $formatear($ahorroNormal + $ahorroRetirable),
            $formatear(array_sum($p)),
            $formatear($inscripcion + $aporte + $ahorroNormal + $ahorroRetirable + array_sum($p))
        ];
    }

    public function columnFormats(): array {
        return ['D:O' => '0.00'];
    }

    public function styles(Worksheet $sheet) {
        $sheet->mergeCells('A1:O1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:O2')->getFont()->setBold(true);
        $sheet->getStyle('A2:O2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');

        $socios = $this->collection();

        foreach ($socios as $index => $socio) {
            $fila = $index + 3;

            // 1. FILA COMPLETA: Socio Nuevo o Salida dentro de la ventana activa
            if ($socio->created_at->between($this->inicioVentana, $this->finVentana) ||
               (!$socio->activo && $socio->updated_at->between($this->inicioVentana, $this->finVentana))) {
                $sheet->getStyle("A{$fila}:O{$fila}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($this->rosado);
                continue;
            }

            // 2. PRÉSTAMOS: Rosado si se creó dentro de la ventana activa o se saldó en ella
            foreach ($socio->prestamos as $prestamo) {
                $esNuevoP = $prestamo->created_at->between($this->inicioVentana, $this->finVentana);
                $fueSaldado = ($prestamo->estado === 'pagado' && $prestamo->updated_at->between($this->inicioVentana, $this->finVentana));

                if ($esNuevoP || $fueSaldado) {
                    $col = match((int)$prestamo->tipo_prestamo_id) {
                        1 => 'H', 2 => 'I', 3 => 'J', 5 => 'K', 4 => 'L', default => null
                    };
                    if ($col) {
                        $sheet->getStyle("{$col}{$fila}")->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($this->rosado);
                    }
                }
            }

            // 3. AHORROS: Rosado si el cambio manual fue dentro de la ventana activa
            foreach ($socio->cuentas as $cuenta) {
                if ($cuenta->manual_change_at && $cuenta->manual_change_at->between($this->inicioVentana, $this->finVentana)) {
                    $codigo = strtoupper($cuenta->type->code ?? '');
                    $colAhorro = match($codigo) {
                        'APO', 'APORTACION' => 'F',
                        'RET', 'VOLUNTARIO' => 'G',
                        default => null
                    };

                    if ($colAhorro) {
                        $sheet->getStyle("{$colAhorro}{$fila}")->getFill()
                            ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($this->rosado);
                    }
                }
            }
        }
    }
}
