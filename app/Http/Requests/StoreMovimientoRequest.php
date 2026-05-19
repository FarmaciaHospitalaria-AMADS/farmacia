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
            'cantidad'   => 'required|integer|min:1',
            'motivo'     => 'nullable|string|max:255',
            'referencia' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'tipo.required'     => 'El tipo de movimiento es obligatorio.',
            'tipo.in'           => 'El tipo debe ser entrada o salida.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.min'      => 'La cantidad debe ser mayor a 0.',
        ];
    }
}