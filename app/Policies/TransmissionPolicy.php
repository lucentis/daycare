<?php

namespace App\Policies;

use App\Models\Transmission;
use App\Models\User;

class TransmissionPolicy
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
        return $user->hasAnyRole(['director', 'staff', 'parent', 'client']);
    }

    public function view(User $user, Transmission $transmission): bool
    {
        if ($user->hasRole('parent')) {
            return $user->children->contains($transmission->child_id);
        }

        return $user->nurseries->contains($transmission->nursery_id);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['director', 'staff']);
    }

    public function update(User $user, Transmission $transmission): bool
    {
        // only the author can update
        return $transmission->author_id === $user->id;
    }

    public function delete(User $user, Transmission $transmission): bool
    {
        if ($user->hasRole('director')) {
            return $user->nurseries->contains($transmission->nursery_id);
        }

        // staff can only delete their own
        return $transmission->author_id === $user->id;
    }
}