<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Politica extends Model
{
    use HasFactory;

    /**
     * 
     */
    protected $table = 'politica';

   
    protected $fillable = [
        'nombre',
        'descripcion',
        'usuario_id',
        'estado',
    ];

    /**
     * Casts para atributos.
     */
    protected $casts = [
        'estado' => 'boolean',
    ];

    /**
     * Relación con el modelo Usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
