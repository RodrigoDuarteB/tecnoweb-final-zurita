<?php

namespace App\Models;

use App\Traits\Modelo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Politica extends Model
{
    use HasFactory;
    use Modelo;

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
     * Relación con el modelo Usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
