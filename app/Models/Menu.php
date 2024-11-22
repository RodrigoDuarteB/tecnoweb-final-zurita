<?php

namespace App\Models;

use App\Traits\Modelo;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use Modelo;

    protected $table = 'menu';
    protected $fillable = ['nombre', 'descripcion', 'estado'];

    public function acciones() {
        return $this->hasMany(Accion::class, 'menu_id');
    }
}
