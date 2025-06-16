<?php

namespace App;

enum FrecuenciaObligacionEnum: string
{
    case Diaria = 'Diaria';
    case Semanal = 'Semanal';
    case Quincenal = 'Quincenal';
    case Mensual = 'Mensual';
    case Anual = 'Anual';
    case UnaVez = 'UnaVez';

    public static function values() {
        return array_column(self::cases(), 'value');
    }
}
