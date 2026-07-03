<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerificaNoUsuario
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'usuario') {
            // Redirigir a una página segura
            return redirect()->route('gracias'); 
        }

        return $next($request);
    }
}
