<?php

namespace Database\Seeders;

use App\Enums\AllergySeverity;
use App\Enums\ChildUserRelation;
use App\Enums\NurseryUserRole;
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

        User::factory()->director()->create([
            'name' => 'director',
            'email' => 'director@gmail.com',
        ]);

        User::factory()->staff()->create([
            'name' => 'staff',
            'email' => 'staff@gmail.com',
        ]);

        User::factory()->parent()->create([
            'name' => 'parent',
            'email' => 'parent@gmail.com',
        ]);

        User::factory()
            ->count(3)
            ->director()
            ->hasAttached(
                Nursery::factory()
                    ->count(2)
                    ->hasAttached(
                        User::factory()->count(3)->staff(),
                        ['role' => NurseryUserRole::Staff->value],
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
                            ->hasAttached(
                                User::factory()->count(2)->parent(),
                                ['relation' => ChildUserRelation::Father->value],
                                'parents'
                            )
                            ->has(
                                Transmission::factory()->count(10)->state(function ($attributes, $child) {
                                    return ['nursery_id' => $child->nursery_id];
                                }),
                                'transmissions'
                            ),
                        'children'
                    ),
                    ['role' => NurseryUserRole::Director->value],
                    'nurseries'
            )
            ->create();
    }
}