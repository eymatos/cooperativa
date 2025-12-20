<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Socio, SavingsAccount, SavingsTransaction, SavingType};
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HistorialAhorrosController extends Controller
{
    public function index() {
        $tipos = SavingType::all();
        return view('admin.importar.historial', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'archivo_csv' => 'required|file',
            'anio' => 'required|integer|min:2011|max:2030',
            'saving_type_id' => 'required|exists:saving_types,id'
        ]);

        $path = $request->file('archivo_csv')->getRealPath();
        $file = fopen($path, 'r');
        $rawHeader = fgetcsv($file, 0, ';');
        $header = array_map(fn($item) => trim($item), $rawHeader);

        $anio = $request->anio;
        $tipoAhorro = SavingType::find($request->saving_type_id);
        $importados = 0;

        $meses = [
            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
            5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
            9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
        ];

        DB::beginTransaction();
        try {
            SavingsTransaction::unsetEventDispatcher();
            SavingsAccount::unsetEventDispatcher();

            while (($row = fgetcsv($file, 0, ';')) !== FALSE) {
                if (count($header) !== count($row)) continue;

                $data = array_combine($header, $row);
                $cedulaCsv = trim($data['cedula']);
                $cedulaLimpia = str_replace('-', '', $cedulaCsv);

                // 1. Vincular con el socio por cédula limpia
                $user = User::whereRaw("REPLACE(cedula, '-', '') = ?", [$cedulaLimpia])->first();

                if (!$user || !$user->socio) continue;
                $socio = $user->socio;

                // 2. BUSCAR LA CUENTA (Cambio Crítico: No sobreescribir recurring_amount)
                // Usamos firstOrCreate pero asegurándonos de que si la crea, no rompa la lógica mensual
                $account = SavingsAccount::firstOrCreate(
                    ['socio_id' => $socio->id, 'saving_type_id' => $tipoAhorro->id],
                    [
                        'balance' => 0,
                        'recurring_amount' => 0 // Solo se usa si la cuenta NO EXISTÍA de la carga previa
                    ]
                );

                // 3. Procesar los 12 meses
                foreach ($meses as $numMes => $nombreMes) {
                    $montoAporte = (float)($data["aporte_$nombreMes"] ?? 0);

                    // Lógica de comentarios mejorada
                    $comentarioRaw = $data["comentarios_$nombreMes"] ?? $data["comentario_$nombreMes"] ?? "";
                    $comentarioConvertido = mb_convert_encoding($comentarioRaw, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
                    $comentarioFinal = trim($comentarioConvertido);

                    if (empty($comentarioFinal)) {
                        $comentario = ($montoAporte < 0) ? "Liquidación de ahorros / Salida" : "Aporte Mensual $anio";
                    } else {
                        $comentario = $comentarioFinal;
                    }

                    // REGISTRO DE MOVIMIENTO
                    if ($montoAporte != 0) {
                        $tipoTransaccion = ($montoAporte > 0) ? 'deposit' : 'withdrawal';

                        SavingsTransaction::create([
                            'savings_account_id' => $account->id,
                            'type' => $tipoTransaccion,
                            'amount' => abs($montoAporte),
                            'date' => Carbon::create($anio, $numMes, 15),
                            'description' => $comentario
                        ]);

                        // Solo actualizamos el balance, NUNCA el recurring_amount
                        $account->balance += $montoAporte;
                    }

                    // REGISTRO DE RETIRO EXTRA
                    if (array_key_exists("retiros_$nombreMes", $data)) {
                        $montoRetiro = (float)$data["retiros_$nombreMes"];
                        if ($montoRetiro > 0) {
                            SavingsTransaction::create([
                                'savings_account_id' => $account->id,
                                'type' => 'withdrawal',
                                'amount' => $montoRetiro,
                                'date' => Carbon::create($anio, $numMes, 20),
                                'description' => "Retiro registrado en $nombreMes $anio"
                            ]);
                            $account->balance -= $montoRetiro;
                        }
                    }
                }

                // Guardamos solo el balance actualizado
                $account->save();
                $importados++;
            }

            DB::commit();
            return back()->with('success', "¡Éxito! Se procesaron $importados socios para el año $anio. Los balances fueron actualizados sin afectar los montos mensuales.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', "Error en el procesamiento: " . $e->getMessage());
        }
    }
}
