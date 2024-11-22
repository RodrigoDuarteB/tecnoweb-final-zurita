<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accion extends Model
{
    use HasFactory;

    /**
     * Tabla 
     */
    protected $table = 'accion';

    /**
     * Atributos 
     */
    protected $fillable = [
        'nombre',
        'es_menu',
        'url',
        'estado',
        'menu_id',
    ];

    /**
     * 
     */
    protected $casts = [
        'es_menu' => 'boolean',
        'estado' => 'boolean',
    ];

    /**
     * 
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
