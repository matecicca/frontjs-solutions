<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Request as RequestModel;
use App\Http\Requests\StoreServiceRequestRequest;

class RequestController extends Controller
{
    /**
     * Muestra el formulario de solicitud de servicio.
     * El usuario debe estar autenticado (protegido por middleware).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = Auth::guard('web')->user();

        return view('request.create', [
            'user' => $user,
        ]);
    }

    /**
     * Procesa y guarda una nueva solicitud de servicio.
     * El user_id se toma del usuario autenticado, no del formulario.
     *
     * @param StoreServiceRequestRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreServiceRequestRequest $request)
    {
        $user = Auth::guard('web')->user();
        $validated = $request->validated();

        // Crear la solicitud vinculada al usuario autenticado
        RequestModel::create([
            'user_id' => $user->id,
            'nombre' => $validated['nombre'],
            'email' => $user->email, // Email del usuario autenticado
            'empresa' => $validated['empresa'],
            'tipo_servicio' => $validated['tipo_servicio'],
            'descripcion_proyecto' => $validated['descripcion_proyecto'],
            'status' => RequestModel::STATUS_REVISION, // Estado inicial
        ]);

        // Redirigir a "Mis Servicios" con mensaje de éxito
        return redirect()
            ->route('user.services.index')
            ->with('success', 'Tu solicitud ha sido enviada correctamente y está en revisión. Te notificaremos cuando sea procesada.');
    }
}
