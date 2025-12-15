<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si NO está logueado O su tipo es 0 (Socio), lo sacamos
        if (!Auth::check() || Auth::user()->tipo == 0) {
            // Opción A: Mandarlo al inicio
            return redirect('/inicio')->with('error', 'No tienes permiso de administrador.');

            // Opción B (Más estricta): Mostrar error 403
            // abort(403, 'ACCESO DENEGADO.');
        }

        return $next($request);
    }
}
