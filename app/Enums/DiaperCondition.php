<?php

namespace App\Enums;

enum DiaperCondition: string
{
    case Normal = 'normal';
    case Abnormal = 'abnormal';

    public function label(): string
    {
        return match($this) {
            self::Normal => 'Normal',
            self::Abnormal => 'Abnormal',
        };
    }
}