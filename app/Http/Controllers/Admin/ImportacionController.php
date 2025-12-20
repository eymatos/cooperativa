<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Socio;
use App\Models\SavingsAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImportacionController extends Controller
{
    public function index() {
        return view('admin.importar.index');
    }

    public function store(Request $request)
    {
        // 1. Validación del archivo
        $request->validate(['archivo_csv' => 'required']);

        $path = $request->file('archivo_csv')->getRealPath();
        $file = fopen($path, 'r');

        // 2. Leer cabecera y convertirla a UTF-8
        $rawHeader = fgetcsv($file, 0, ';');
        if (!$rawHeader) {
            return back()->with('error', 'El archivo CSV está vacío.');
        }
        $header = array_map(fn($item) => mb_convert_encoding($item, 'UTF-8', 'ISO-8859-1'), $rawHeader);

        $importados = 0;
        $passwordBase = Hash::make('coo123perativa');

        // Mapa de salarios manual desde PDF
        $salariosPdf = [
            '223-0119516-4' => 46000.00, '226-0003399-1' => 60000.00,
            '012-0007465-4' => 35000.00, '001-1746512-0' => 140000.00,
            '402-2671751-6' => 30000.00, '402-1299714-8' => 35000.00,
            '402-2396980-5' => 40000.00, '402-2945387-9' => 35000.00,
        ];

        // 3. Seguridad: Desactivar restricciones para la carga masiva
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Socio::unsetEventDispatcher();
        User::unsetEventDispatcher();
        SavingsAccount::unsetEventDispatcher();

        try {
            while (($row = fgetcsv($file, 0, ';')) !== FALSE) {
                // Convertir cada valor a UTF-8
                $row = array_map(fn($item) => $item ? mb_convert_encoding($item, 'UTF-8', 'ISO-8859-1') : $item, $row);

                $data = array_combine($header, $row);
                $cedula = trim($data['cedula']);

                // --- PROCESAMIENTO DE FECHA DE INSCRIPCIÓN ---
                $fechaRaw = trim($data['fecha_inscripcion']);
                try {
                    $fechaInscripcion = ($fechaRaw && $fechaRaw !== '0000-00-00')
                        ? Carbon::parse(str_replace('/', '-', $fechaRaw))
                        : now();
                } catch (\Exception $e) {
                    $fechaInscripcion = now();
                }

                // 4. Gestionar Usuario (Tabla 'users')
                $user = User::where('cedula', $cedula)->first() ?: new User();
                $user->cedula = $cedula;
                $user->name = trim($data['nombre']) . ' ' . trim($data['apellido']);
                $user->email = !empty($data['email']) ? $data['email'] : 'socio_' . $data['id'] . '@cooprocon.com';
                if (!$user->exists) {
                    $user->password = $passwordBase;
                }
                $user->tipo = 0;

                // FORZAR FECHA: Desactivamos timestamps para que acepte la fecha del pasado
                $user->timestamps = false;
                $user->created_at = $fechaInscripcion;
                $user->updated_at = $fechaInscripcion;
                $user->save();

                $salario = (float)$data['salario'] > 0 ? (float)$data['salario'] : ($salariosPdf[$cedula] ?? 0.00);

                // 5. Gestionar Socio (Tabla 'socios')
                $socio = Socio::where('user_id', $user->id)->first() ?: new Socio();
                $socio->user_id = $user->id;
                $socio->nombres = trim($data['nombre']);
                $socio->apellidos = trim($data['apellido']);
                $socio->telefono = '809-000-0000';
                $socio->direccion = 'No registrada';
                $socio->salario = $salario;
                $socio->sueldo = $salario;
                $socio->lugar_trabajo = 'PROCONSUMIDOR';
                $socio->activo = ($data['estatus'] == 1);
                $socio->tipo_contrato = ($data['contrato'] == 'F' ? 'fijo' : 'contratado');

                // FORZAR FECHA TAMBIÉN EN SOCIO
                $socio->timestamps = false;
                $socio->created_at = $fechaInscripcion;
                $socio->updated_at = $fechaInscripcion;
                $socio->save();

                // 6. Reconectar o Crear Cuentas de Ahorro (CORREGIDO: Usando updateOrCreate para evitar duplicados)

                // Ahorro Normal (Tipo 1)
                SavingsAccount::updateOrCreate(
                    ['socio_id' => $socio->id, 'saving_type_id' => 1],
                    [
                        'recurring_amount' => (float)$data['guia'],
                        // El balance se mantiene si ya existe, si no, se crea en 0 por base de datos
                    ]
                );

                // Ahorro Retirable (Tipo 2)
                if ((float)$data['guia_reti'] > 0) {
                    SavingsAccount::updateOrCreate(
                        ['socio_id' => $socio->id, 'saving_type_id' => 2],
                        [
                            'recurring_amount' => (float)$data['guia_reti']
                        ]
                    );
                }

                $importados++;
            }
            fclose($file);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return back()->with('success', "¡Sincronización Exitosa! Se procesaron $importados registros con sus fechas reales.");
        } catch (\Exception $e) {
            if ($file) fclose($file);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return back()->with('error', "Error en el registro #$importados: " . $e->getMessage());
        }
    }
}
