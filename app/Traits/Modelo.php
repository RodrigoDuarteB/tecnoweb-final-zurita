<?php

namespace App\Traits;

use App\Models\User;

trait Modelo {

    public function scopeActivos($query) {
        return $query->where('estado', 'Activo');
    }

    public function usuarioCreador() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function eliminar() {
        $this->update(['estado' => 'Inactivo']);
    }
}
