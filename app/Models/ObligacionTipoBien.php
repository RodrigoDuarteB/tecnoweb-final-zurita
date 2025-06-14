<?php

namespace App\Models;

use App\Traits\Modelo;
use Illuminate\Database\Eloquent\Model;

class ObligacionTipoBien extends Model
{
    use Modelo;
    protected $table = 'obligacion_tipo_bien';
    protected $fillable = [
        'tipo_bien_id',
        'nombre',
        'tipo',
        'precio',
        'frecuencia',
        'estado',
    ];

    public function tipoBien()
    {
        return $this->belongsTo(TipoBien::class, 'tipo_bien_id');
    }
}
