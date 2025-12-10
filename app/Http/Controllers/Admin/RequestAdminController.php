<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Request as RequestModel;
use App\Http\Requests\UpdateServiceStatusRequest;
use App\Mail\ServiceAcceptedMail;
use App\Mail\ServiceRejectedMail;

class RequestAdminController extends Controller
{
    /**
     * Muestra el listado de todas las solicitudes de servicio recibidas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $requests = RequestModel::with('user')
            ->latest()
            ->get();

        return view('admin.requests.index', compact('requests'));
    }

    /**
     * Muestra el detalle de una solicitud específica.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $request = RequestModel::with('user')->findOrFail($id);

        return view('admin.requests.show', compact('request'));
    }

    /**
     * Actualiza el estado de una solicitud y envía email si corresponde.
     *
     * @param UpdateServiceStatusRequest $httpRequest
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(UpdateServiceStatusRequest $httpRequest, $id)
    {
        $validated = $httpRequest->validated();

        $serviceRequest = RequestModel::with('user')->findOrFail($id);

        $previousStatus = $serviceRequest->status;
        $newStatus = $validated['status'];

        // Actualizar la solicitud
        $serviceRequest->status = $newStatus;
        $serviceRequest->admin_message = $validated['admin_message'];

        // Si se acepta, registrar la fecha de aceptación
        if ($newStatus === RequestModel::STATUS_ACEPTADO && $previousStatus !== RequestModel::STATUS_ACEPTADO) {
            $serviceRequest->accepted_at = now();

            // Enviar email al usuario
            try {
                // Usar el email de la solicitud (que es el del usuario)
                Mail::to($serviceRequest->email)->send(new ServiceAcceptedMail($serviceRequest));

                $serviceRequest->save();

                return redirect()
                    ->route('admin.requests.show', $id)
                    ->with('success', 'Solicitud aceptada y email enviado correctamente al usuario.');
            } catch (\Exception $e) {
                $serviceRequest->save();

                return redirect()
                    ->route('admin.requests.show', $id)
                    ->with('warning', 'Solicitud aceptada pero hubo un error al enviar el email: ' . $e->getMessage());
            }
        }

        // Si se rechaza, opcionalmente enviar email
        if ($newStatus === RequestModel::STATUS_RECHAZADO && $previousStatus !== RequestModel::STATUS_RECHAZADO) {
            $serviceRequest->accepted_at = now(); // Usamos el mismo campo para registrar la fecha de respuesta

            try {
                Mail::to($serviceRequest->email)->send(new ServiceRejectedMail($serviceRequest));

                $serviceRequest->save();

                return redirect()
                    ->route('admin.requests.show', $id)
                    ->with('success', 'Solicitud rechazada y email enviado correctamente al usuario.');
            } catch (\Exception $e) {
                $serviceRequest->save();

                return redirect()
                    ->route('admin.requests.show', $id)
                    ->with('warning', 'Solicitud rechazada pero hubo un error al enviar el email: ' . $e->getMessage());
            }
        }

        $serviceRequest->save();

        return redirect()
            ->route('admin.requests.show', $id)
            ->with('success', 'Estado de la solicitud actualizado correctamente.');
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

        return redirect()
            ->route('admin.requests.index')
            ->with('success', 'Solicitud eliminada correctamente.');
    }
}
