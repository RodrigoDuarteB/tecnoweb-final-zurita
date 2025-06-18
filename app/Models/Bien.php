<?php

namespace App\Models;

use App\Traits\Modelo;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use Modelo;
    protected $table = 'bien';
    protected $fillable = [
        'cliente_id',
        'tipo_bien_id',
        'nombre',
        'descripcion',
        'valor_referencial',
        'estado',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function tipoBien()
    {
        return $this->belongsTo(TipoBien::class, 'tipo_bien_id');
    }

    public function obligaciones() {
        return $this->hasMany(Obligacion::class, 'bien_id');
    }
}
