<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $table = 'alertas';

    protected $fillable = [
        'insumo_id',
        'tipo',
        'mensaje',
        'leida',
    ];

    protected $casts = [
        'leida' => 'boolean',
    ];

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'insumo_id');
    }

    public function noLeidas($query)
    {
        return $query->where('leida', false);
    }

    public function deStockBajo($query)
    {
        return $query->where('tipo', 'stock_bajo');
    }

    public function porVencer($query)
    {
        return $query->where('tipo', 'por_vencer');
    }
}