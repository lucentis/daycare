<?php

namespace App\Policies;

use App\Models\Child;
use App\Models\User;

class ChildPolicy
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

    public function view(User $user, Child $child): bool
    {
        // parent can only view their own children
        if ($user->hasRole('parent')) {
            return $user->children->contains($child);
        }

        // director and staff can view children in their nurseries
        return $user->nurseries->contains($child->nursery_id);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['director', 'staff']);
    }

    public function update(User $user, Child $child): bool
    {
        if ($user->hasRole('director')) {
            return $user->nurseries->contains($child->nursery_id);
        }

        return false;
    }

    public function delete(User $user, Child $child): bool
    {
        return $user->hasRole('director') &&
            $user->nurseries->contains($child->nursery_id);
    }
}