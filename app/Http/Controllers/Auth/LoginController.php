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

    // 🔥 Redirección por tipo
    return match ($user->tipo) {
        1 => redirect()->route('soporte.dashboard'),
        2 => redirect()->route('admin.dashboard'),
        default => redirect()->route('socio.dashboard'),
    };
}


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
