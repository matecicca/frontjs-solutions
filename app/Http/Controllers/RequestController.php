<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Request as RequestModel;

class RequestController extends Controller
{
    /**
     * Muestra el formulario de solicitud de servicio.
     * Si hay un usuario autenticado, precarga su email en el formulario.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Obtener el usuario autenticado (si existe) del guard 'web'
        $user = Auth::guard('web')->user();

        // Pasar el email del usuario autenticado a la vista (o null si no está autenticado)
        $userEmail = $user ? $user->email : null;

        return view('request.create', compact('userEmail'));
    }

    /**
     * Procesa y guarda una nueva solicitud de servicio.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validaciones del formulario con mensajes personalizados
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'empresa' => 'nullable|string|max:255',
            'tipo_servicio' => 'required|string|max:255',
            'descripcion_proyecto' => 'required|string|min:10|max:1000',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debe ser un email válido.',
            'email.max' => 'El email no puede exceder 255 caracteres.',
            'empresa.max' => 'El nombre de la empresa no puede exceder 255 caracteres.',
            'tipo_servicio.required' => 'Debe seleccionar un tipo de servicio.',
            'descripcion_proyecto.required' => 'La descripción del proyecto es obligatoria.',
            'descripcion_proyecto.min' => 'La descripción debe tener al menos 10 caracteres.',
            'descripcion_proyecto.max' => 'La descripción no puede exceder 1000 caracteres.',
        ]);

        // Guardar en la base de datos
        RequestModel::create($validated);

        // Redirigir con mensaje de éxito
        return redirect()
            ->route('request.create')
            ->with('success', 'Tu solicitud ha sido enviada correctamente. Nos pondremos en contacto pronto.');
    }
}
