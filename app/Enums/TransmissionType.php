<?php

namespace App\Enums;

enum TransmissionType: string
{
    case Nap = 'nap';
    case Meal = 'meal';
    case Diaper = 'diaper';
    case Activity = 'activity';
    case Health = 'health';
    case Note = 'note';

    public function label(): string
    {
        return match($this) {
            self::Nap => 'Nap',
            self::Meal => 'Meal',
            self::Diaper => 'Diaper',
            self::Activity => 'Activity',
            self::Health => 'Health',
            self::Note => 'Note',
        };
    }
}