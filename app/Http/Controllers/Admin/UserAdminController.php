<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    /**
     * Muestra la lista paginada de usuarios.
     * Los usuarios se ordenan por fecha de creación descendente (más recientes primero).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener usuarios paginados, ordenados por fecha de creación (más recientes primero)
        $users = User::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra el detalle completo de un usuario específico.
     * Usa Route Model Binding para obtener automáticamente el usuario.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}
