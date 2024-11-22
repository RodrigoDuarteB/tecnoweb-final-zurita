<?php

namespace App\Traits;

trait Modelo {

    public function scopeActivos($query) {
        return $query->where('estado', 'Activo');
    }
}
