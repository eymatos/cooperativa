<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'cedula' => 'required',
            'password' => 'required',
        ]);

        // --- CAMBIO AQUÍ: Limpiamos la cédula que viene del formulario ---
        // Esto quita los guiones para buscar el valor "limpio" en la BD
        $cedulaLimpia = str_replace('-', '', $request->cedula);

        // Buscamos al usuario con la cédula ya normalizada
        $user = User::where('cedula', $cedulaLimpia)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'cedula' => 'Cédula o contraseña incorrecta',
            ]);
        }

        Auth::login($user);

        // LÓGICA SIMPLIFICADA (Solo Admin o Socio)
        return match ((int)$user->tipo) {
            2 => redirect()->route('admin.dashboard'), // Si es 2 -> Admin
            default => redirect()->route('socio.dashboard'), // 0 (o cualquier otro) -> Socio
        };
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
