<?php

namespace App\Policies;

use App\Models\Nursery;
use App\Models\User;

class NurseryPolicy
{
    // admin can do everything
    public function before(User $user): ?bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['director', 'client']);
    }

    public function view(User $user, Nursery $nursery): bool
    {
        return $user->nurseries()->withTrashed()->whereKey($nursery->id)->exists();
    }

    public function create(User $user): bool
    {
        return $user->hasRole('client');
    }

    public function update(User $user, Nursery $nursery): bool
    {
        return $user->nurseries()->withTrashed()->whereKey($nursery->id)->exists();
    }

    public function delete(User $user, Nursery $nursery): bool
    {
        return $user->hasRole('client')
            && $user->nurseries()->withTrashed()->whereKey($nursery->id)->exists();
    }

    public function restore(User $user, Nursery $nursery): bool
    {
        return $user->hasRole('client')
            && $user->nurseries()->withTrashed()->whereKey($nursery->id)->exists();
    }
}