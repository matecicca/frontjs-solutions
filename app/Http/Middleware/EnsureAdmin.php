<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     *
     * Verifica que el usuario esté autenticado con el guard 'admin'
     * y que tenga el role 'admin'.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado con el guard 'admin'
        if (!Auth::guard('admin')->check()) {
            // No está autenticado, redirigir al login de admin
            return redirect()->route('admin.login')
                ->with('error', 'Debes iniciar sesión como administrador para acceder.');
        }

        // Verificar si el usuario autenticado es admin
        $user = Auth::guard('admin')->user();

        if (!$user->isAdmin()) {
            // Está autenticado pero no es admin, redirigir a home con mensaje de error
            return redirect('/')
                ->with('error', 'No tienes permisos para acceder al panel de administración.');
        }

        // Es admin, permitir el acceso
        return $next($request);
    }
}
