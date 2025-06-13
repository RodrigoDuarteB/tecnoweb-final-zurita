<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoBien extends Model
{
    protected $table = 'tipo_bien';
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    public function bienes()
    {
        return $this->hasMany(Bien::class, 'tipo_bien_id');
    }

    public function obligaciones()
    {
        return $this->hasMany(ObligacionTipoBien::class, 'tipo_bien_id');
    }
}
