<?php

namespace App\Enums;

enum DiaperType: string
{
    case Wet = 'wet';
    case Dirty = 'dirty';
    case Both = 'both';

    public function label(): string
    {
        return match($this) {
            self::Wet => 'Wet',
            self::Dirty => 'Dirty',
            self::Both => 'Both',
        };
    }
}