<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Request as RequestModel;

class UserServiceController extends Controller
{
    /**
     * Muestra el listado de solicitudes del usuario autenticado.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::guard('web')->user();

        // Obtener solicitudes del usuario ordenadas por fecha (más recientes primero)
        $requests = RequestModel::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('user.services.index', compact('requests'));
    }

    /**
     * Muestra el detalle de una solicitud específica del usuario.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = Auth::guard('web')->user();

        // Buscar la solicitud asegurándose de que pertenezca al usuario autenticado
        $request = RequestModel::where('user_id', $user->id)
            ->findOrFail($id);

        return view('user.services.show', compact('request'));
    }
}
