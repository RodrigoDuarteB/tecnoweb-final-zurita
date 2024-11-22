<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    /**
     * Tabla 
     */
    protected $table = 'cliente';

    /**
     * Atributos 
     */
    protected $fillable = [
        'estado',
        'carnet_identidad',
        'usuario_id',
    ];

   
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
