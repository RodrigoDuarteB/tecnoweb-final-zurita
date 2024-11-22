<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
    protected $fillable = ['nombre', 'descripcion', 'estado', 'editable', 'listable'];

    public function permisos() {
        return $this->hasMany(Permiso::class, 'rol_id');
    }
}
