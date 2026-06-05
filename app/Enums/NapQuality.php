<?php

namespace App\Enums;

enum NapQuality: string
{
    case Agitated = 'agitated';
    case Average = 'average';
    case Good = 'good';

    public function label(): string
    {
        return match($this) {
            self::Agitated => 'Agitated',
            self::Average => 'Average',
            self::Good => 'Good',
        };
    }
}