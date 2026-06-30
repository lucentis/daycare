<?php

namespace Database\Factories;

use App\Models\Nursery;
use Illuminate\Database\Eloquent\Factories\Factory;

class NurseryFactory extends Factory
{
    protected $model = Nursery::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Nursery',
            'address' => fake()->streetAddress() . ', ' . fake()->city(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
            'capacity' => fake()->numberBetween(20, 40),
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