<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function update(User $authUser, User $targetUser): bool
    {
        // Allow users to update only themselves
        return $authUser->id === $targetUser->id;
    }
}
