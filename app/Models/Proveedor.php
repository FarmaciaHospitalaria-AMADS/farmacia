<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = ['nombre', 'telefono', 'email'];

    public function insumos()
    {
        return $this->hasMany(Insumo::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}