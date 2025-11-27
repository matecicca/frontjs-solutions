<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    /**
     * Muestra la lista paginada de usuarios.
     */
    public function index()
    {
        // Obtener usuarios paginados, ordenados por fecha de creación (más recientes primero)
        $users = User::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra el detalle de un usuario específico.
     *
     * Usa Route Model Binding para obtener automáticamente el usuario.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}
