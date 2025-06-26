<?php

namespace App\Http\Requests;

use App\FrecuenciaObligacionEnum;
use App\TipoObligacionEnum;
use Illuminate\Foundation\Http\FormRequest;

class TipoBienStoreRequest extends FormRequest
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
            'nombre' => 'required|string|unique:tipo_bien,nombre',
            'descripcion' => 'nullable|string|max:1000',
            'obligaciones' => 'required|array',
            'obligaciones.*.nombre' => 'required|string',
            'obligaciones.*.precio' => 'required|numeric',
            'obligaciones.*.frecuencia' => "required|in:" . FrecuenciaObligacionEnum::imploded(),
            'obligaciones.*.tipo' => "required|in:" . TipoObligacionEnum::imploded(),
        ];
    }
}
