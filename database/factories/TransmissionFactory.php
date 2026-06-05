<?php

namespace Database\Factories;

use App\Enums\DiaperCondition;
use App\Enums\DiaperType;
use App\Enums\MealQuantity;
use App\Enums\MealType;
use App\Enums\NapQuality;
use App\Enums\TransmissionType;
use App\Models\Transmission;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransmissionFactory extends Factory
{
    protected $model = Transmission::class;

    public function definition(): array
    {
        $type = fake()->randomElement(TransmissionType::cases());

        return [
            'type' => $type,
            'payload' => $this->generatePayload($type),
            'notes' => fake()->optional(0.3)->sentence(),
            'noted_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    private function generatePayload(TransmissionType $type): array
    {
        return match($type) {
            TransmissionType::Nap => $this->napPayload(),
            TransmissionType::Meal => $this->mealPayload(),
            TransmissionType::Diaper => $this->diaperPayload(),
            TransmissionType::Activity => $this->activityPayload(),
            TransmissionType::Health => $this->healthPayload(),
            TransmissionType::Note => $this->notePayload(),
        };
    }

    private function napPayload(): array
    {
        $start = fake()->dateTimeBetween('-4 hours', '-1 hour');
        $end = fake()->dateTimeBetween($start, 'now');

        return [
            'start_at' => $start->format('H:i'),
            'end_at' => $end->format('H:i'),
            'quality' => fake()->randomElement(NapQuality::cases())->value,
        ];
    }

    private function mealPayload(): array
    {
        return [
            'meal_type' => fake()->randomElement(MealType::cases())->value,
            'ate_well' => fake()->boolean(),
            'quantity' => fake()->randomElement(MealQuantity::cases())->value,
            'menu' => fake()->randomElement([
                'pasta with vegetables',
                'chicken with rice',
                'fish with mashed potatoes',
                'vegetable soup',
                'yogurt with fruit',
            ]),
        ];
    }

    private function diaperPayload(): array
    {
        return [
            'type' => fake()->randomElement(DiaperType::cases())->value,
            'condition' => fake()->randomElement(DiaperCondition::cases())->value,
        ];
    }

    private function activityPayload(): array
    {
        return [
            'name' => fake()->randomElement([
                'painting', 'drawing', 'singing', 'dancing',
                'outdoor play', 'reading', 'puzzle', 'building blocks',
            ]),
            'description' => fake()->sentence(),
        ];
    }

    private function healthPayload(): array
    {
        $medicineGiven = fake()->boolean();

        return [
            'temperature' => fake()->optional(0.5)->randomFloat(1, 36.0, 40.0),
            'symptoms' => fake()->optional(0.7)->randomElement([
                'runny nose', 'coughing', 'fever', 'rash', 'vomiting',
            ]),
            'medicine_given' => $medicineGiven,
            'medicine_name' => $medicineGiven ? fake()->randomElement(['doliprane', 'advil', 'nurofen']) : null,
            'medicine_dose' => $medicineGiven ? fake()->randomElement(['2.5ml', '5ml', '1 tablet']) : null,
        ];
    }

    private function notePayload(): array
    {
        return [
            'content' => fake()->paragraph(),
        ];
    }
}