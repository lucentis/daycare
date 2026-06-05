<?php

namespace Database\Factories;

use App\Models\Allergy;
use Illuminate\Database\Eloquent\Factories\Factory;

class AllergyFactory extends Factory
{
    protected $model = Allergy::class;

    // realistic allergy names rather than random words
    protected static array $allergies = [
        'Peanuts', 'Tree nuts', 'Milk', 'Eggs', 'Wheat',
        'Soy', 'Fish', 'Shellfish', 'Sesame', 'Gluten',
        'Latex', 'Penicillin', 'Dust mites', 'Cat dander', 'Pollen',
    ];

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
        ];
    }
}