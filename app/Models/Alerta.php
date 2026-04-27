<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $table = 'alertas';

    protected $fillable = [
        'lote_id',
        'tipo',
        'mensaje'
    ];

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }
}
