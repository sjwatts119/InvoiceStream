<?php

namespace App\Policies;

use App\Models\Arrangement;
use App\Models\User;

class ArrangementPolicy
{
    public function update(User $user, Arrangement $arrangement): bool
    {
        return $arrangement->user->is($user);
    }

    public function delete(User $user, Arrangement $arrangement): bool
    {
        return $arrangement->user->is($user);
    }
}
