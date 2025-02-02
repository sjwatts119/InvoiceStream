<?php

namespace App\Observers;

use App\Models\Address;
use App\Models\User;

class UserObserver
{
    public function creating(User $user): void
    {
        $user->address()->save(new Address);
    }

    public function deleting(User $user): void
    {
        $user->arrangements->each(function ($arrangement) {
            $arrangement->delete();
        });

        $user->address->delete();
    }
}
