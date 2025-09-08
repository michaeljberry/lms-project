<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;

class ProfilePolicy
{
    public function view(User $authUser, Profile $profile): bool
    {
        return $authUser->id === $profile->user_id;
    }

    public function update(User $authUser, Profile $profile): bool
    {
        return $authUser->id === $profile->user_id;
    }
}
