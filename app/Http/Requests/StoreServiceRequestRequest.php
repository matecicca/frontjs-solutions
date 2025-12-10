<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Solo usuarios autenticados pueden hacer solicitudes
        return auth()->guard('web')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'empresa' => 'nullable|string|max:255',
            'tipo_servicio' => 'required|string|in:React,Vue,Mantenimiento,Otro',
            'descripcion_proyecto' => 'required|string|min:10|max:1000',
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
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
            'empresa.max' => 'El nombre de la empresa no puede exceder 255 caracteres.',
            'tipo_servicio.required' => 'Debe seleccionar un tipo de servicio.',
            'tipo_servicio.in' => 'El tipo de servicio seleccionado no es válido.',
            'descripcion_proyecto.required' => 'La descripción del proyecto es obligatoria.',
            'descripcion_proyecto.min' => 'La descripción debe tener al menos 10 caracteres.',
            'descripcion_proyecto.max' => 'La descripción no puede exceder 1000 caracteres.',
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
            'nombre' => 'nombre',
            'empresa' => 'empresa',
            'tipo_servicio' => 'tipo de servicio',
            'descripcion_proyecto' => 'descripción del proyecto',
        ];
    }
}
