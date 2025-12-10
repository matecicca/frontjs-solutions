<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Request as RequestModel;

class UpdateServiceStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Solo administradores pueden cambiar estados
        return auth()->guard('admin')->check() &&
               auth()->guard('admin')->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'required|in:' . implode(',', RequestModel::STATUSES),
            'admin_message' => 'required_if:status,aceptado|nullable|string|max:2000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'status.required' => 'Debe seleccionar un estado.',
            'status.in' => 'El estado seleccionado no es válido. Los estados permitidos son: en revisión, aceptado, rechazado.',
            'admin_message.required_if' => 'El mensaje es obligatorio cuando se acepta una solicitud.',
            'admin_message.max' => 'El mensaje no puede exceder 2000 caracteres.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'status' => 'estado',
            'admin_message' => 'mensaje para el usuario',
        ];
    }
}
