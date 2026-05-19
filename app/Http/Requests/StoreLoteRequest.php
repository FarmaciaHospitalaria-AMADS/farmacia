<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreLoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(Auth::user()->role_id, [1, 2]);
    }

    public function rules(): array
    {
        return [
            'codigo_lote'       => 'required|string|unique:lotes,codigo_lote',
            'insumo_id'         => 'required|exists:insumos,id',
            'cantidad_inicial'  => 'required|integer|min:1',
            'fecha_vencimiento' => 'required|date|after:today',
            'proveedor'         => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo_lote.unique'        => 'Ya existe un lote con ese código.',
            'codigo_lote.required'      => 'El código de lote es obligatorio.',
            'insumo_id.required'        => 'Debe seleccionar un insumo.',
            'insumo_id.exists'          => 'El insumo seleccionado no existe.',
            'cantidad_inicial.required' => 'La cantidad inicial es obligatoria.',
            'cantidad_inicial.min'      => 'La cantidad debe ser mayor a 0.',
            'fecha_vencimiento.after'   => 'La fecha de vencimiento debe ser futura.',
        ];
    }
}