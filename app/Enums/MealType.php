<?php

namespace App\Enums;

enum MealType: string
{
    case Breakfast = 'breakfast';
    case MorningSnack = 'morning_snack';
    case Lunch = 'lunch';
    case AfternoonSnack = 'afternoon_snack';
    case Dinner = 'dinner';

    public function label(): string
    {
        return match($this) {
            self::Breakfast => 'Breakfast',
            self::MorningSnack => 'Morning Snack',
            self::Lunch => 'Lunch',
            self::AfternoonSnack => 'Afternoon Snack',
            self::Dinner => 'Dinner',
        };
    }
}