<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class EntryForm extends Form
{
    public ?float $hours = null;

    public ?float $rate = null;

    public ?string $date = null;

    public function rules(): array
    {
        return [
            'hours' => ['required', 'numeric'],
            'rate' => ['required', 'numeric'],
            'date' => ['required', 'date', 'before_or_equal:today'],
        ];
    }
}
