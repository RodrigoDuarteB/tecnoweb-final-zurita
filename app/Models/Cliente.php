<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';

    protected $fillable = ['carnet_identidad', 'usuario_id', 'estado'];

    public function usuario() {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function bienes() {
        return $this->hasMany(Bien::class, 'cliente_id');
    }

}
