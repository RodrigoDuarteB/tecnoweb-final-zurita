<?php

namespace App\Models;

use App\Traits\Modelo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    use Modelo;


    protected $table = 'pago';

    /**
     * Atributos
     */
    protected $fillable = [
        'fecha_hora',
        'fecha_hora_confirmacion',
        'qr_imagen',
        'cliente_id',
        'estado',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Relacion
     */
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_pago');
    }
}
