<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolStoreRequest extends FormRequest
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
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'permisos' => 'nullable|array',
            'permisos.*.menu_id' => 'required|integer',
            'permisos.*.acciones' => 'required|array',
            'permisos.*.acciones.*' => 'integer',
        ];
    }
}
