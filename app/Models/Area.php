<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';

    protected $fillable = ['nombre', 'ubicacion_id'];

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }

    public function insumos()
    {
        return $this->hasMany(Insumo::class);
    }
}
