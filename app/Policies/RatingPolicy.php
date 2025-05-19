<?php

namespace App\Policies;

use App\Models\Rating;
use App\Models\User;

class RatingPolicy
{
    public function update(User $user, Rating $rating)
    {
        return $user->id === $rating->user_id;
    }

    public function delete(User $user, Rating $rating)
    {
        return $user->id === $rating->user_id;
    }
} 