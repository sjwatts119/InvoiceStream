<?php

namespace App\Policies;

use App\Models\Arrangement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArrangementPolicy
{
    public function view(User $user, Arrangement $arrangement): Response
    {
        return $arrangement->user->is($user)
            ? Response::allow()
            : Response::denyWithStatus('404');
    }

    public function update(User $user, Arrangement $arrangement): Response
    {
        return $arrangement->user->is($user)
            ? Response::allow()
            : Response::denyWithStatus('404');
    }

    public function delete(User $user, Arrangement $arrangement): Response
    {
        return $arrangement->user->is($user)
            ? Response::allow()
            : Response::denyWithStatus('404');
    }
}
