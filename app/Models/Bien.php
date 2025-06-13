<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
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
}
