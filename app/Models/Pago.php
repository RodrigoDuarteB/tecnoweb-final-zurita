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

    /**
     * Relación con el modelo Cliente.
     * (Asegúrate de tener un modelo Cliente si es necesario).
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
