<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permiso';
    protected $fillable = ['rol_id', 'accion_id', 'estado'];

    public function rol() {
        return $this->belongsTo(Rol::class);
    }

    public function accion() {
        return $this->belongsTo(Accion::class);
    }
}
