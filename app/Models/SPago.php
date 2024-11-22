<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioPago extends Model
{
    use HasFactory;

    /**
     * 
     */
    protected $table = 'servicio_pago';

    /**
     * 
     */
    protected $fillable = [
        'estado',
        'porcentaje_descuento',
        'servicio_id',
        'pago_id',
        'monto_servicio',
        'subtotal',
        'total_descuento',
        'monto_descuento',
    ];

    /**
     * 
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    
    public function pago()
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }
}
