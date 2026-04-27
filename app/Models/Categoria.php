<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = ['nombre'];

    public function insumos()
    {
        return $this->hasMany(Insumo::class);
    }
}