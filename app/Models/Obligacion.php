<?php

namespace App\Models;

use App\Traits\Modelo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

   protected function fechaVencimiento(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->format('d/m/Y H:i') : null,
        );
    }

    public function bien()
    {
        return $this->belongsTo(Bien::class, 'bien_id');
    }

    public function obligacionTipoBien()
    {
        return $this->belongsTo(ObligacionTipoBien::class, 'obligacion_tipo_bien_id');
    }
}
