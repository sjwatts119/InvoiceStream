<?php

namespace App\Policies;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EntryPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Entry $entry): bool
    {
        return $entry->arrangement?->user?->is($user) ?? false;
    }
}
