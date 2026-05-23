<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreMovimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(Auth::user()->role_id, [1, 2, 3]);
    }

    public function rules(): array
    {
        return [
            'tipo'       => 'required|in:entrada,salida',
            'cantidad'   => 'required|integer|min:1|max:999999',
            'motivo'     => 'nullable|string|max:255',
            'referencia' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'cantidad.required'  => 'La cantidad es obligatoria.',
            'cantidad.integer'   => 'La cantidad debe ser un número entero.',
            'cantidad.min'       => 'La cantidad mínima es 1.',
            'cantidad.max'       => 'La cantidad excede el límite permitido.',
            'tipo.in'            => 'El tipo de movimiento no es válido.',
            'motivo.max'         => 'El motivo no puede superar los 255 caracteres.',
            'referencia.max'     => 'La referencia no puede superar los 255 caracteres.',
        ];
    }
}