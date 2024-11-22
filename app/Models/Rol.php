<?php

namespace App\Models;

use App\Traits\Modelo;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use Modelo;

    protected $table = 'rol';
    protected $fillable = ['nombre', 'descripcion', 'estado', 'editable', 'listable'];

    public function permisos() {
        return $this->hasMany(Permiso::class, 'rol_id');
    }

    public function acciones() {
        return $this->belongsToMany(Accion::class, 'permiso');
    }
}
