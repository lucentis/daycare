<?php

namespace Database\Factories;

use App\Models\Child;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChildFactory extends Factory
{
    protected $model = Child::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            // between 3 months and 4 years old
            'date_of_birth' => fake()->dateTimeBetween('-4 years', '-3 months')->format('Y-m-d'),
            'photo' => null,
            'active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }
}