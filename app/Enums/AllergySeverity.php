<?php

namespace App\Enums;

enum AllergySeverity: string
{
    case Mild = 'mild';
    case Moderate = 'moderate';
    case Severe = 'severe';

    public function label(): string
    {
        return match($this) {
            self::Mild => 'Mild',
            self::Moderate => 'Moderate',
            self::Severe => 'Severe',
        };
    }
}