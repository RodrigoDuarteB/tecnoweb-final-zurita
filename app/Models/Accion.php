<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accion extends Model
{
    protected $table = 'accion';
    protected $fillable = ['nombre', 'es_menu', 'url', 'menu_id', 'estado'];

    public function menu() {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
