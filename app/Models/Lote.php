<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lote extends Model
{
    protected $fillable = [
        'codigo_lote', 'insumo_id', 'cantidad_inicial',
        'cantidad_actual', 'fecha_vencimiento', 'fecha_entrada',
        'proveedor', 'estado', 'registrado_por',
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'fecha_entrada'     => 'date',
    ];
    
    public function insumo(): BelongsTo
    {
        return $this->belongsTo(Insumo::class);
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class);
    }

    public function registrador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    public function estaVencido(): bool
    {
        return $this->fecha_vencimiento->isPast();
    }

    public function tieneStock(int $cantidad): bool
    {
        return $this->cantidad_actual >= $cantidad;
    }
}