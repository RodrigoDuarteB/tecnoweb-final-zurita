<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    /**
     * Tabla 
     */
    protected $table = 'servicio';

    /**
     * Atributos 
     */
    protected $fillable = [
        'nombre',
        'precio',
        'estado',
        'usuario_id',
    ];

    /**
     * Casts para atributos.
     */
    protected $casts = [
        'estado' => 'boolean',
    ];
    public function servicioDescuentos()
    {
        return $this->hasMany(ServicioDescuento::class, 'servicio_id');
    }

    public function servicioPagos()
    {
        return $this->hasMany(ServicioPago::class, 'servicio_id');
    }

    /**
     * 
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
