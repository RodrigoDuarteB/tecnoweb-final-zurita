<?php

namespace App\Models;

use App\Traits\Modelo;
use Illuminate\Database\Eloquent\Model;

class Obligacion extends Model
{
    use Modelo;
    protected $table = 'obligacion';
    protected $fillable = [
        'bien_id',
        'obligacion_tipo_bien_id',
        'fecha_vencimiento',
        'corresponde_a',
        'user_id',
        'estado',
    ];

    public function bien()
    {
        return $this->belongsTo(Bien::class, 'bien_id');
    }

    public function obligacionTipoBien()
    {
        return $this->belongsTo(ObligacionTipoBien::class, 'obligacion_tipo_bien_id');
    }
}
