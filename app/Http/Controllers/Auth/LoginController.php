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

    $user = User::where('cedula', $request->cedula)->first();

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
