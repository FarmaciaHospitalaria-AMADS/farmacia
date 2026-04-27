<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';

    protected $fillable = [
        'lote_id',
        'tipo',
        'cantidad'
    ];

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }
}
