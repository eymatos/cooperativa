<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SavingType;
use App\Models\SavingsAccount;

class AhorroController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Asegurarnos de que el usuario tenga un perfil de Socio
        if (!$user->socio) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes un perfil de socio asociado.');
        }

        $socio = $user->socio;

        // Cargar las cuentas del socio con su tipo
        // Si no existen, la colección estará vacía (luego migraremos la data)
        $cuentas = $socio->cuentas()->with('type')->get();

        // Obtenemos los tipos de ahorro por si queremos mostrar opciones disponibles
        $tiposDisponibles = SavingType::all();

        return view('ahorros.index', compact('socio', 'cuentas', 'tiposDisponibles'));
    }
    // Mostrar el historial de una cuenta específica
    public function show($id)
    {
        $cuenta = SavingsAccount::with(['type', 'transactions' => function($query) {
            $query->orderBy('date', 'desc'); // Ordenar: lo más reciente primero
        }])->findOrFail($id);

        // SEGURIDAD: Verificar que la cuenta pertenezca al socio logueado
        if ($cuenta->socio_id != Auth::user()->socio->id) {
            abort(403, 'No tienes permiso para ver esta cuenta.');
        }

        return view('ahorros.show', compact('cuenta'));
    }
    // Aquí luego agregaremos métodos para 'deposit' (Aportar) y 'withdraw' (Retirar)
}
