<?php

namespace App\Traits;

trait ValidatesEntries
{
    protected function baseEntryRules(): array
    {
        return [
            'required',
            'array',
            'exists:entries,id',
        ];
    }
}
