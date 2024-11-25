<?php

namespace App\Models;

use App\Traits\Modelo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    use HasFactory;
    use Modelo;

    /**
     * Table
     */
    protected $table = 'descuento';


    protected $fillable = [
        'nombre',
        'descripcion',
        'monto',
        'porcentaje',
        'estado',
        'usuario_id',
        'fecha_inicio',
        'fecha_fin',
        'activo',
    ];


    protected $casts = [
        'activo' => 'boolean',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    protected function fechaInicio(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->format('d/m/Y') : null,
        );
    }

    protected function fechaFin(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->format('d/m/Y') : null,
        );
    }

    protected $appends = ['fecha_inicio_for_input', 'fecha_fin_for_input'];

    protected function getFechaInicioForInputAttribute()
    {
        return $this->attributes['fecha_inicio']
        ? Carbon::parse($this->attributes['fecha_inicio'])->format('Y-m-d')
        : null;
    }

    protected function getFechaFinForInputAttribute()
    {
        return $this->attributes['fecha_fin']
        ? Carbon::parse($this->attributes['fecha_fin'])->format('Y-m-d')
        : null;
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_descuento');
    }
}
