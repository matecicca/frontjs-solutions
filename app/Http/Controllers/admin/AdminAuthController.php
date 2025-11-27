<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        // Si ya está logueado con guard admin, mandamos al dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        // Validación con mensajes personalizados
        $request->validate([
            'name'     => 'required|string',
            'password' => 'required|string',
        ], [
            'name.required' => 'El nombre de usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Recuperamos por 'name' (admin) y validamos password
        $user = User::where('name', $request->name)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Login usando guard 'admin' explícitamente
            Auth::guard('admin')->login($user, true);
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // Mensaje genérico para no revelar si el usuario existe
        return back()->withErrors(['name' => 'Las credenciales proporcionadas son incorrectas.'])->withInput();
    }

    public function logout(Request $request)
    {
        // Logout usando guard 'admin' explícitamente
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
