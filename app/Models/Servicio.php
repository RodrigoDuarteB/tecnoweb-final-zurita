<?php

namespace App\Models;

use App\Traits\Modelo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    use Modelo;

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


    public function descuentos()
    {
        return $this->belongsToMany(Descuento::class, 'servicio_descuento');
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
