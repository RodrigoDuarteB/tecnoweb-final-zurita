<?php

namespace App;

enum TipoObligacionEnum: string
{
    case Impuesto = 'Impuesto';
    case Tasa = 'Tasa';
    case Multa = 'Multa';
    case Otro = 'Otro';

    public static function values() {
        return array_column(self::cases(), 'value');
    }

    public static function imploded() {
        return implode(',', self::values());
    }
}
