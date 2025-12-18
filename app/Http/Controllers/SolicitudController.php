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
     * He implementado filtros dinámicos para mantener la lista limpia.
     */
    public function indexAdmin(Request $request)
{
    // Forzamos a que sean enteros (int)
    $mes = (int) $request->get('mes', date('m'));
    $anio = (int) $request->get('anio', date('Y'));

    $solicitudes = Solicitud::with('user')
        ->whereMonth('created_at', $mes)
        ->whereYear('created_at', $anio)
        ->latest()
        ->get();

    $mesesFiltro = [];
    for ($m = 1; $m <= 12; $m++) {
        // Aquí Carbon ya recibe un entero puro $m
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
                // 1. Crear/Actualizar Usuario
                $user = User::updateOrCreate(
                    ['cedula' => $solicitud->datos['cedula']],
                    [
                        'name' => $solicitud->datos['nombres'] . ' ' . $solicitud->datos['apellidos'],
                        'email' => $solicitud->datos['correo'],
                        'password' => Hash::make(str_replace('-', '', $solicitud->datos['cedula'])),
                        'tipo' => 0
                    ]
                );

                // 2. Crear Socio
                Socio::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nombres'       => $solicitud->datos['nombres'],
                        'apellidos'     => $solicitud->datos['apellidos'],
                        'telefono'      => $solicitud->datos['telefono'],
                        'direccion'     => $solicitud->datos['direccion'],
                        'tipo_contrato' => $solicitud->datos['tipo_contrato'] ?? 'fijo',
                        'sueldo'        => $solicitud->datos['sueldo'] ?? 0,
                        'salario'       => $solicitud->datos['sueldo'] ?? 0,
                        'lugar_trabajo' => $solicitud->datos['lugar_trabajo'] ?? 'PRO CONSUMIDOR',
                        'ahorro_total'  => 0,
                        'activo'        => true,
                    ]
                );

                // 3. Crear cuentas de ahorro (Aportaciones y Retirable)
                if ($user->socio) {
                    if ($user->socio->cuentas()->where('saving_type_id', 3)->count() == 0) {
                        $user->socio->cuentas()->create([
                            'saving_type_id' => 3,
                            'balance' => 0,
                            'codigo' => 'AP-' . $user->id,
                            'recurring_amount' => $solicitud->datos['monto_ahorro_normal'] ?? 0
                        ]);
                    }

                    $montoRetirable = $solicitud->datos['monto_ahorro_retirable'] ?? 0;
                    if ($montoRetirable > 0 && $user->socio->cuentas()->where('saving_type_id', 4)->count() == 0) {
                        $user->socio->cuentas()->create([
                            'saving_type_id' => 4,
                            'balance' => 0,
                            'codigo' => 'RT-' . $user->id,
                            'recurring_amount' => $montoRetirable
                        ]);
                    }
                }

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Fallo en Socio: ' . $e->getMessage());
            }
        }

        $solicitud->update(['estado' => $nuevoEstado]);

        return redirect()->route('admin.solicitudes.index')
            ->with('success', '✅ Socio registrado y solicitud procesada con éxito.');
    }

    public function descargarPdf($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        return view('admin.solicitudes.pdf_inscripcion', compact('solicitud'));
    }
}
