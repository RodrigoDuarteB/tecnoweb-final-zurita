<?php

namespace App;

enum FrecuenciaEnum
{
    case Diaria;
    case Semanal;
    case Quincenal;
    case Mensual;
    case Anual;

    public function label(): string
    {
        return match ($this) {
            self::Diaria => 'Diaria',
            self::Semanal => 'Semanal',
            self::Quincenal => 'Quincenal',
            self::Mensual => 'Mensual',
            self::Anual => 'Anual',
        };
    }
    public function value(): string
    {
        return match ($this) {
            self::Diaria => 'Diaria',
            self::Semanal => 'Semanal',
            self::Quincenal => 'Quincenal',
            self::Mensual => 'Mensual',
            self::Anual => 'Anual',
        };
    }
}
