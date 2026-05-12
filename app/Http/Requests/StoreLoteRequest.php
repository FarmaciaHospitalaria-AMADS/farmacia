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
            'codigo_lote'       => 'required|string|min:4|max:50|unique:lotes,codigo_lote',
            'insumo_id'         => 'required|exists:insumos,id',
            'cantidad_inicial'  => 'required|integer|min:1|max:999999',
            'fecha_vencimiento' => 'required|date|after:today',
            'proveedor'         => 'nullable|string|max:100',

        ];
    }

    public function messages(): array
    {
        return [
            'codigo_lote.required'       => 'El código de lote es obligatorio.',
            'codigo_lote.min'            => 'El código debe tener al menos 4 caracteres.',
            'codigo_lote.max'            => 'El código no puede superar los 50 caracteres.',
            'codigo_lote.unique'         => 'Este código de lote ya existe.',
            'insumo_id.required'         => 'Debe seleccionar un insumo.',
            'insumo_id.exists'           => 'El insumo seleccionado no es válido.',
            'cantidad_inicial.required'  => 'La cantidad es obligatoria.',
            'cantidad_inicial.integer'   => 'La cantidad debe ser un número entero.',
            'cantidad_inicial.min'       => 'La cantidad mínima es 1.',
            'cantidad_inicial.max'       => 'La cantidad no puede superar 999,999.',
            'fecha_vencimiento.required' => 'La fecha de vencimiento es obligatoria.',
            'fecha_vencimiento.date'     => 'La fecha no tiene un formato válido.',
            'fecha_vencimiento.after'    => 'La fecha debe ser posterior a hoy.',
            'proveedor.max'              => 'El proveedor no puede superar los 100 caracteres.',
        ];
    }
}