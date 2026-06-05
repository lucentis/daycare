<?php

namespace App\Policies;

use App\Models\Allergy;
use App\Models\User;

class AllergyPolicy
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

    public function view(User $user, Allergy $allergy): bool
    {
        return $user->hasAnyRole(['director', 'staff']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['director', 'staff']);
    }

    public function update(User $user, Allergy $allergy): bool
    {
        return $user->hasAnyRole(['director', 'staff']);
    }

    public function delete(User $user, Allergy $allergy): bool
    {
        return $user->hasRole('director');
    }
}