<?php

namespace App\Policies;

use App\Models\Medication;
use App\Models\User;

class MedicationPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['director', 'staff']);
    }

    public function view(User $user, Medication $medication): bool
    {
        return $user->hasAnyRole(['director', 'staff']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['director', 'staff']);
    }

    public function update(User $user, Medication $medication): bool
    {
        return $user->hasAnyRole(['director', 'staff']);
    }

    public function delete(User $user, Medication $medication): bool
    {
        return $user->hasRole('director');
    }
}