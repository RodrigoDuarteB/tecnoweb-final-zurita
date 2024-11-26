<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'servicios' => 'required|array',
            'servicios.*.' => 'required|array',
            'servicios.*.servicio_id' => 'required|integer',
            'servicios.*.monto_servicio' => 'required|numeric',
            'servicios.*.monto_descuento' => 'nullable|numeric',
            'servicios.*.porcentaje_descuento' => 'nullable|numeric',
            'servicios.*.subtotal' => 'required|numeric',
            'servicios.*.total_descuento' => 'nullable|numeric',
            'servicios.*.cantidad' => 'required|integer',
        ];
    }
}
