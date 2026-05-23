<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';

    protected $fillable = [
        'nombre',
        'categoria_id',
        'proveedor_id',
        'area_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class);
    }

        public function estado() {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
