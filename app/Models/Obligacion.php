<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obligacion extends Model
{
    protected $table = 'obligacion';
    protected $fillable = [
        'bien_id',
        'obligacion_tipo_bien_id',
        'fecha_vencimiento',
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
