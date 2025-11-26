<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as RequestModel;

class RequestController extends Controller
{
    public function create()
    {
        return view('request.create');
    }

    public function store(Request $request)
    {
        // Validaciones del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'empresa' => 'nullable|string|max:255',
            'tipo_servicio' => 'required|string|max:255',
            'descripcion_proyecto' => 'required|string|min:10',
        ]);

        // Guardar en la base de datos
        RequestModel::create($validated);

        // Redirigir con mensaje de éxito
        return redirect()
            ->route('request.create')
            ->with('success', 'Tu solicitud ha sido enviada correctamente. Nos pondremos en contacto pronto.');
    }
}
