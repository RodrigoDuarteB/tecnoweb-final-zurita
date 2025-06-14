<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BienStoreRequest extends FormRequest
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
            'tipo_bien_id' => 'required|exists:tipo_bien,id',
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'valor_referencial' =>  'required|numeric',
        ];
    }
}
