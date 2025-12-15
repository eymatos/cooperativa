<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario NO es tipo 1 (Admin), lo sacamos
        if (Auth::check() && Auth::user()->tipo != 1) {
            return redirect()->route('socio.dashboard'); // O abort(403);
        }

        return $next($request);
    }
}
