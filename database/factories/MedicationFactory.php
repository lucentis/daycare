<?php

namespace Database\Factories;

use App\Models\Medication;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicationFactory extends Factory
{
    protected $model = Medication::class;

    protected static array $medications = [
        'Doliprane', 'Advil', 'Amoxicillin', 'Ventolin',
        'Cetirizine', 'Ibuprofen', 'Paracetamol', 'Nurofen',
        'Augmentin', 'Singulair', 'Flixotide', 'Aerius',
    ];

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(self::$medications),
        ];
    }
}