<?php

namespace App\Enums;

enum ChildUserRelation: string
{
    case Mother = 'mother';
    case Father = 'father';
    case Guardian = 'guardian';

    public function label(): string
    {
        return match($this) {
            self::Mother => 'Mother',
            self::Father => 'Father',
            self::Guardian => 'Guardian',
        };
    }
}