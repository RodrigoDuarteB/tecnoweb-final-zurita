<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     */
    protected $table = 'menu';

    /**
     * Atributos 
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

   
    protected $casts = [
        'estado' => 'boolean',
    ];
}
