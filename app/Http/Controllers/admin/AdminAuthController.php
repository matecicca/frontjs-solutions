<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Muestra el formulario de login del panel.
     * Si ya hay sesión admin, redirige al dashboard.
     */
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Procesa el login de administrador.
     */
    public function login(Request $request)
    {
        // Validación básica de credenciales
        $credentials = $request->validate([
            'name'     => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'name.required'     => 'El usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Intentar autenticar usando el guard 'admin'
        $remember = $request->boolean('remember');

        $attempt = Auth::guard('admin')->attempt([
            'name'     => $credentials['name'],
            'password' => $credentials['password'],
        ], $remember);

        if ($attempt) {
            // Verificar que el usuario autenticado tenga rol 'admin'
            $user = Auth::guard('admin')->user();

            if (!$user->isAdmin()) {
                // No es admin, cerrar sesión y rechazar
                Auth::guard('admin')->logout();

                return back()
                    ->withErrors(['name' => 'No tienes permisos de administrador.'])
                    ->withInput();
            }

            // Regenerar la sesión para evitar fixation
            $request->session()->regenerate();

            // Redirigir a la ruta que el usuario quería (si estaba protegida)
            // o al dashboard principal del panel
            return redirect()->intended(route('admin.dashboard'));
        }

        // Si falla, mensaje genérico
        return back()
            ->withErrors(['name' => 'Las credenciales proporcionadas son incorrectas.'])
            ->withInput();
    }

    /**
     * Cierra la sesión del administrador.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
