<?php

namespace App\Models;

use App\Traits\Modelo;
use Illuminate\Database\Eloquent\Model;

class Accion extends Model
{
    use Modelo;

    protected $table = 'accion';
    protected $fillable = ['nombre', 'es_menu', 'url', 'menu_id', 'estado'];

    public function menu() {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function roles() {
        return $this->belongsToMany(Rol::class, 'permiso');
    }
}
