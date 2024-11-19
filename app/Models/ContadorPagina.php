<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Request;

class ContadorPagina extends Model
{
    protected $table = 'contador_pagina';
    protected $fillable = [
        'ruta',
        'conteo'
    ];

    public static function contar() {
        $ruta = Request::path();
        $obj = self::firstOrCreate(['ruta' => $ruta]);
        $obj->increment('conteo');
        return $obj->conteo;
    }
}
