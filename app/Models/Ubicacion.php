<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ubicacion extends Model
{
    protected $table = 'ubicaciones';

    protected $fillable = ['nombre'];

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function lotes(): HasMany
    {
        return $this->hasMany(Lote::class);
    }
}