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
        return $user->hasRole('director');
    }

    public function view(User $user, Nursery $nursery): bool
    {
        return $user->nurseries->contains($nursery);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Nursery $nursery): bool
    {
        return $user->nurseries->contains($nursery);
    }

    public function delete(User $user, Nursery $nursery): bool
    {
        return false;
    }
}