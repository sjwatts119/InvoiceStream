<?php

namespace App\Rules\Arrangement;

use App\Models\Entry;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnsureInvoiced implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $entries = Entry::whereIn('id', $value)->get();

        if ($entries->contains(fn (Entry $entry) => !$entry->invoiced)) {
            $fail('One or more entries do not have an invoice.');
        }
    }
}
