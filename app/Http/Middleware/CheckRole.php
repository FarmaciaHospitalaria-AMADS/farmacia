<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $roleId)
    {
        // Si el usuario no está logueado o su rol no coincide con el requerido
        if (!Auth::check() || Auth::user()->role_id != $roleId) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
