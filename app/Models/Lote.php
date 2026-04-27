<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lotes';

    protected $fillable = [
        'insumo_id',
        'fecha_vencimiento',
        'cantidad_actual'
    ];

    public function insumo()
    {
        return $this->belongsTo(Insumo::class);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}