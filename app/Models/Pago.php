<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

   
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
    public function servicioPagos()
    {
        return $this->hasMany(ServicioPago::class, 'pago_id');
    }
}
