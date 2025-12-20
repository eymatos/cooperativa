<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Socio, User, Prestamo, Cuota, TipoPrestamo};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImportacionPrestamosController extends Controller
{
    /**
     * Muestra el formulario de importación
     */
    public function index()
    {
        $tipos = TipoPrestamo::all();
        return view('admin.importar.prestamos', compact('tipos'));
    }

    /**
     * Procesa el archivo CSV de préstamos con lógica de amortización y pagos automáticos
     */
    public function store(Request $request)
    {
        $request->validate([
            'archivo_csv' => 'required|file',
        ]);

        // MAPEADOR: Relaciona los nombres del CSV con los IDs de tu DB
        $mapaTipos = [
            'prestamos_normales'     => 1,
            'prestamos_escolares'    => 2,
            'prestamos_educativos'   => 3,
            'prestamos_vacacionales' => 4,
            'prestamos_express'      => 5,
        ];

        $path = $request->file('archivo_csv')->getRealPath();
        $file = fopen($path, 'r');

        $rawHeader = fgetcsv($file, 0, ';');
        $header = array_map(fn($i) => trim($i), $rawHeader);

        $importados = 0;
        $fechaLimitePagos = Carbon::parse('2025-12-20');

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($file, 0, ';')) !== FALSE) {
                $data = array_combine($header, $row);

                $cedulaLimpia = str_replace('-', '', trim($data['cedula']));
                $user = User::whereRaw("REPLACE(cedula, '-', '') = ?", [$cedulaLimpia])->first();

                if (!$user || !$user->socio) continue;
                $socio = $user->socio;

                // DETERMINACIÓN DEL TIPO (Prioridad al CSV, respaldo al selector)
                $tipoEnCsv = trim($data['tipo'] ?? '');
                $tipoId = $mapaTipos[$tipoEnCsv] ?? $request->tipo_prestamo_id;

                if (!$tipoId) {
                    throw new \Exception("No se reconoció el tipo '{$tipoEnCsv}' para la cédula {$data['cedula']}.");
                }

                $monto = (float)$data['monto'];
                $tasaInteresAnual = (float)$data['interes'];
                $plazo = (int)$data['plazo'];
                $estatusCSV = (int)$data['estatus'];

                $fechaInicio = Carbon::parse($data['fecha_prestamo']);
                $fechaPrimeraCuota = Carbon::parse($data['primera_cuota']);

                $prestamo = Prestamo::create([
                    'socio_id' => $socio->id,
                    'tipo_prestamo_id' => $tipoId,
                    'numero_prestamo' => $data['numero_prestamo'],
                    'monto' => $monto,
                    'tasa_interes' => $tasaInteresAnual,
                    'plazo' => $plazo,
                    'saldo_capital' => $monto,
                    'fecha_solicitud' => $fechaInicio,
                    'fecha_inicio' => $fechaInicio,
                    'estado' => ($estatusCSV == 1) ? 'activo' : 'pagado'
                ]);

                $totalPagar = (float)$data['total_pagar'];
                $montoCuotaTotal = $totalPagar / $plazo;
                $capitalPorCuota = $monto / $plazo;
                $interesPorCuota = $montoCuotaTotal - $capitalPorCuota;

                $saldoProyectado = $monto;
                $fechaCorrienteCuota = $fechaPrimeraCuota->copy();

                for ($i = 1; $i <= $plazo; $i++) {
                    $saldoProyectado -= $capitalPorCuota;

                    $estaPagada = ($estatusCSV == 0) || ($estatusCSV == 1 && $fechaCorrienteCuota->lessThanOrEqualTo($fechaLimitePagos));

                    Cuota::create([
                        'prestamo_id' => $prestamo->id,
                        'numero_cuota' => $i,
                        'fecha_vencimiento' => $fechaCorrienteCuota->copy(),
                        'monto_total' => $montoCuotaTotal,
                        'interes' => $interesPorCuota,
                        'capital' => $capitalPorCuota,
                        'saldo_restante' => max(0, $saldoProyectado),
                        'abonado' => $estaPagada ? $montoCuotaTotal : 0,
                        'estado' => $estaPagada ? 'pagada' : 'pendiente'
                    ]);

                    if ($estaPagada) {
                        $prestamo->saldo_capital -= $capitalPorCuota;
                    }

                    $fechaCorrienteCuota->addMonth();
                }

                if ($prestamo->saldo_capital < 0.01) {
                    $prestamo->saldo_capital = 0;
                }

                $prestamo->save();
                $importados++;
            }

            DB::commit();
            fclose($file);
            return back()->with('success', "Migración Inteligente Exitosa: $importados préstamos procesados reconociendo tipos y cuotas a Dic 2025.");

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($file)) fclose($file);
            return back()->with('error', "Error en la línea " . ($importados + 2) . ": " . $e->getMessage());
        }
    }
}
