<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
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
        'estado' => 'boolean',
        'activo' => 'boolean',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

  
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
