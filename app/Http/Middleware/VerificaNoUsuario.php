<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerificaNoUsuario
{
    public function handle($request, Closure $next)
    {
        /*if (Auth::check() && strtolower(Auth::user()->rol) === 'usuario') {
            // Redirigir a una página segura
            return redirect()->route('gracias'); 
        }*/
        if (Auth::check() && strtolower(Auth::user()->rol) === 'usuario') 
        {
            Auth::logout(); // cerrar sesión
            return redirect()->route('login')
                ->withErrors(['acceso' => 'Tu cuenta no tiene credenciales de acceso válidas.']);
        }


        return $next($request);
    }
}
