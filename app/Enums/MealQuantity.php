<?php

namespace App\Enums;

enum MealQuantity: string
{
    case None = 'none';
    case Little = 'little';
    case Half = 'half';
    case Most = 'most';
    case All = 'all';

    public function label(): string
    {
        return match($this) {
            self::None => 'None',
            self::Little => 'Little',
            self::Half => 'Half',
            self::Most => 'Most',
            self::All => 'All',
        };
    }
}