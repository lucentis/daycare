<?php

namespace Database\Seeders;

use App\Enums\AllergySeverity;
use App\Enums\ChildUserRelation;
use App\Models\Allergy;
use App\Models\Child;
use App\Models\Medication;
use App\Models\Nursery;
use App\Models\Transmission;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
        ]);

        User::factory()
            ->count(3)
            ->director()
            ->has(
                Nursery::factory()
                    ->count(2)
                    ->has(
                        User::factory()->count(5)->staff(),
                        'staff'
                    )
                    ->has(
                        Child::factory()
                            ->count(10)
                            ->hasAttached(
                                Allergy::factory()->count(2),
                                [
                                    'severity' => AllergySeverity::Mild->value,
                                    'notes' => null,
                                ],
                                'allergies'
                            )
                            ->hasAttached(
                                Medication::factory()->count(1),
                                [
                                    'dosage' => '2.5ml',
                                    'frequency' => 'morning',
                                    'active' => true,
                                    'started_at' => now()->subMonths(2)->format('Y-m-d'),
                                    'ended_at' => null,
                                    'notes' => null,
                                ],
                                'medications'
                            )
                            ->has(
                                User::factory()->count(2)->parent(),
                                'parents'
                            )
                            ->has(
                                Transmission::factory()->count(20),
                                'transmissions'
                            ),
                        'children'
                    ),
                'nurseries'
            )
            ->create();
    }
}