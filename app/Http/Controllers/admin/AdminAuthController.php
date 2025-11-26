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
        // Si ya está logueado, mandamos al dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'password' => 'required|string',
        ]);

        // Recuperamos por 'name' (admin) y validamos password
        $user = User::where('name', $request->name)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, true);
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['name' => 'Credenciales inválidas'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
