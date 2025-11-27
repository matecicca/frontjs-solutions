<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Registra un nuevo usuario.
     */
    public function register(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debe ser un email válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Crear usuario con contraseña hasheada y role = 'user'
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        // Login automático después del registro
        Auth::guard('web')->login($user);

        return redirect('/')->with('success', '¡Registro exitoso! Bienvenido/a.');
    }

    /**
     * Muestra el formulario de login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Autentica al usuario.
     */
    public function login(Request $request)
    {
        // Validación de credenciales
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debe ser un email válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Buscar el usuario por email
        $user = User::where('email', $credentials['email'])->first();

        // Verificar si el usuario existe y la contraseña es correcta
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Las credenciales proporcionadas son incorrectas.',
            ]);
        }

        // Determinar el guard apropiado según el rol del usuario
        if ($user->isAdmin()) {
            // Usuario admin: autenticar con guard 'admin' y redirigir al panel admin
            Auth::guard('admin')->login($user, $request->filled('remember'));
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))->with('success', '¡Bienvenido/a al panel de administración!');
        } else {
            // Usuario normal: autenticar con guard 'web' y redirigir al home
            Auth::guard('web')->login($user, $request->filled('remember'));
            $request->session()->regenerate();

            return redirect()->intended('/')->with('success', '¡Bienvenido/a de nuevo!');
        }
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        // Cerrar sesión en ambos guards por seguridad
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }
}
