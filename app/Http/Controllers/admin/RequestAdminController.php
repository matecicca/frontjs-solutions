<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;

class RequestAdminController extends Controller
{
    /**
     * Muestra el listado de todas las solicitudes de servicio recibidas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $requests = RequestModel::latest()->get();
        return view('admin.requests.index', compact('requests'));
    }

    /**
     * Elimina una solicitud de servicio de la base de datos.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function destroy($id)
    {
        RequestModel::findOrFail($id)->delete();
        return redirect()->route('admin.requests.index')->with('success', 'Solicitud eliminada.');
    }
}
