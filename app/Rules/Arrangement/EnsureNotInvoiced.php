<?php

namespace App\Rules\Arrangement;

use App\Models\Entry;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnsureNotInvoiced implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $entries = Entry::whereIn('id', $value)->get();

        if ($entries->contains(fn (Entry $entry) => $entry->invoiced)) {
            $fail('You cannot invoice an entry twice.');
        }
    }
}
