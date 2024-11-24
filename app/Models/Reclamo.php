<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamo extends Model
{
    use HasFactory;

    /**
     * Tabla 
     */
    protected $table = 'reclamo';

    /**
     * Atributos 
     */
    protected $fillable = [
        'cliente_id',
        'estado',
        'reclamo',
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

}
