<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $fillable = ['nombre', 'descripcion', 'estado'];

    public function acciones() {
        return $this->hasMany(Accion::class, 'menu_id');
    }
}
