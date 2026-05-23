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
     * Usamos ...$roles para capturar todos los roles separados por coma (Ej: role:1,2)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Verificamos si el usuario ha iniciado sesión
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Convertimos el role_id a string para asegurarnos de que coincida con los parámetros de la ruta
        $userRole = (string) Auth::user()->role_id;

        // 3. Verificamos si el rol del usuario actual ESTÁ en el arreglo de roles permitidos
        if (!in_array($userRole, $roles)) {
            
            // Si es un farmacéutico (Rol 2) intentando entrar a un área puramente de Admin
            if (Auth::user()->role_id == 2) {
                return redirect('/farmacia/dashboard')->with('error', 'Acceso denegado: Área exclusiva de administración.');
            }

            // Bloqueo genérico
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        // Si su rol está en la lista permitida, pasa sin problemas
        return $next($request);
    }
}