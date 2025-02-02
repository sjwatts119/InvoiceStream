<?php

namespace App\Observers;

use App\Models\Address;
use App\Models\User;

class UserObserver
{
    public function creating(User $user): void
    {
        // Make a new address for the user
        $user->address()->save(new Address);
    }
}
