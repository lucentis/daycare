<?php

namespace App\Enums;

enum NurseryUserRole: string
{
    case Director = 'director';
    case Staff = 'staff';

    public function label(): string
    {
        return match($this) {
            self::Director => 'Director',
            self::Staff => 'Staff',
        };
    }
}