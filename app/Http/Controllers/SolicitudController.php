<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Socio;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SolicitudController extends Controller
{
    // Guarda la solicitud enviada por el socio o aspirante
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string',
            'datos' => 'required|array',
        ]);

        Solicitud::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'tipo' => $request->tipo,
            'datos' => $request->datos,
            'estado' => 'pendiente'
        ]);

        if (Auth::check()) {
            return redirect()->route('socio.dashboard')->with('success', 'Solicitud enviada correctamente.');
        }

        return redirect()->route('login')->with('success', 'Su solicitud de inscripción ha sido recibida.');
    }

    /**
     * Listado para el Administrador (ORGANIZADO POR MES)
     */
    public function indexAdmin(Request $request)
    {
        // Forzamos a que sean enteros (int) para evitar errores de Carbon
        $mes = (int) $request->get('mes', date('m'));
        $anio = (int) $request->get('anio', date('Y'));

        $solicitudes = Solicitud::with('user')
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $anio)
            ->latest()
            ->get();

        $mesesFiltro = [];
        for ($m = 1; $m <= 12; $m++) {
            $mesesFiltro[$m] = ucfirst(Carbon::create()->month($m)->translatedFormat('F'));
        }

        return view('admin.solicitudes.index', compact('solicitudes', 'mes', 'anio', 'mesesFiltro'));
    }

    // Detalle de una solicitud específica para el Administrador
    public function showAdmin($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        return view('admin.solicitudes.show', compact('solicitud'));
    }

    public function updateEstado(Request $request, $id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $nuevoEstado = $request->estado;

        if ($nuevoEstado == 'procesada' && $solicitud->estado != 'procesada') {
            try {
                // CASO A: SOLICITUD DE INSCRIPCIÓN (Aspirantes nuevos)
                if ($solicitud->tipo == 'inscripcion') {
                    $user = User::updateOrCreate(
                        ['cedula' => $solicitud->datos['cedula']],
                        [
                            'name' => $solicitud->datos['nombres'] . ' ' . $solicitud->datos['apellidos'],
                            'email' => $solicitud->datos['correo'],
                            'password' => Hash::make(str_replace('-', '', $solicitud->datos['cedula'])),
                            'tipo' => 0
                        ]
                    );

                    $socio = Socio::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'nombres'       => $solicitud->datos['nombres'],
                            'apellidos'     => $solicitud->datos['apellidos'],
                            'telefono'      => $solicitud->datos['telefono'],
                            'direccion'     => $solicitud->datos['direccion'],
                            'sueldo'        => $solicitud->datos['sueldo'] ?? 0,
                            'activo'        => true,
                        ]
                    );

                    if ($socio) {
                        // Cuenta de Aportaciones (ID 3)
                        $socio->cuentas()->updateOrCreate(
                            ['saving_type_id' => 3],
                            [
                                'balance' => 0,
                                'codigo' => 'AP-' . $user->id,
                                'recurring_amount' => $solicitud->datos['monto_ahorro_normal'] ?? 0
                            ]
                        );

                        // Cuenta Retirable (ID 4) si aplica
                        $montoRetirable = $solicitud->datos['monto_ahorro_retirable'] ?? 0;
                        if ($montoRetirable > 0) {
                            $socio->cuentas()->updateOrCreate(
                                ['saving_type_id' => 4],
                                [
                                    'balance' => 0,
                                    'codigo' => 'RT-' . $user->id,
                                    'recurring_amount' => $montoRetirable
                                ]
                            );
                        }
                    }
                }

                // CASO B: AUTORIZACIÓN AHORRO NORMAL (Socios existentes)
                elseif ($solicitud->tipo == 'autorizacion_ahorro') {
                    $socio = Socio::where('user_id', $solicitud->user_id)->first();
                    if (!$socio) throw new \Exception("Socio no encontrado para el usuario ID: " . $solicitud->user_id);

                    $cuenta = $socio->cuentas()->where('saving_type_id', 3)->first();
                    if ($cuenta) {
                        $cuenta->update(['recurring_amount' => $solicitud->datos['monto_ahorro']]);
                    } else {
                        throw new \Exception("El socio no posee una cuenta de Aportaciones configurada.");
                    }
                }
// CASO E: SUSPENSIÓN AHORRO RETIRABLE
elseif ($solicitud->tipo == 'suspension_ahorro_retirable') {
    $socio = Socio::where('user_id', $solicitud->user_id)->first();
    if (!$socio) throw new \Exception("Socio no encontrado.");

    $cuentaRetirable = $socio->cuentas()->where('saving_type_id', 4)->first();
    if ($cuentaRetirable) {
        // Ponemos el monto de ahorro mensual en 0
        $cuentaRetirable->update(['recurring_amount' => 0]);
    }
}
                // CASO C: INSCRIPCIÓN O GESTIÓN AHORRO RETIRABLE (ID 4)
                // Unificamos la lógica para 'inscripcion_ahorro_retirable' y 'gestion_ahorro_retirable'
                elseif ($solicitud->tipo == 'inscripcion_ahorro_retirable' || $solicitud->tipo == 'gestion_ahorro_retirable') {
                    $socio = Socio::where('user_id', $solicitud->user_id)->first();
                    if (!$socio) throw new \Exception("Socio no encontrado para el usuario ID: " . $solicitud->user_id);

                    $socio->cuentas()->updateOrCreate(
                        ['saving_type_id' => 4],
                        [
                            'codigo' => 'RT-' . $socio->user_id,
                            'recurring_amount' => $solicitud->datos['monto_retirable']
                        ]
                    );
                }

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Fallo al procesar: ' . $e->getMessage());
            }
        }

        $solicitud->update(['estado' => $nuevoEstado]);

        return redirect()->route('admin.solicitudes.index')
            ->with('success', '✅ Solicitud procesada y datos actualizados correctamente.');
    }

    public function descargarPdf($id)
{
    $solicitud = Solicitud::findOrFail($id);

    if ($solicitud->tipo === 'autorizacion_ahorro') {
        return view('admin.solicitudes.pdf_autorizacion_ahorro', compact('solicitud'));
    }

    // ESTE ES EL CAMBIO: Separarlos por completo
    if ($solicitud->tipo === 'inscripcion_ahorro_retirable') {
        return view('admin.solicitudes.pdf_inscripcion_retirable', compact('solicitud'));
    }

    if ($solicitud->tipo === 'gestion_ahorro_retirable') {
        return view('admin.solicitudes.pdf_gestion_retirable', compact('solicitud'));
    }
    if ($solicitud->tipo === 'solicitud_prestamo') {
    return view('admin.solicitudes.pdf_prestamo', compact('solicitud'));
    }
    if ($solicitud->tipo === 'suspension_ahorro_retirable') {
        return view('admin.solicitudes.pdf_suspension_retirable', compact('solicitud'));
    }
    if ($solicitud->tipo === 'retiro_ahorro_retirable') {
        return view('admin.solicitudes.pdf_retiro_retirable', compact('solicitud'));
    }

    return view('admin.solicitudes.pdf_inscripcion', compact('solicitud'));
}

}
