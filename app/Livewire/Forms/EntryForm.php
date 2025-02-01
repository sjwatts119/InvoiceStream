<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class EntryForm extends Form
{
    public ?string $hours = null;

    public ?string $rate = null;

    public ?string $date = null;

    public ?string $notes = null;

    public function rules(): array
    {
        return [
            'hours' => ['required', 'numeric', 'max:24'],
            'rate' => ['required', 'numeric'],
            'date' => ['required', 'date', 'before_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation($attributes)
    {
        if ($this->rate === '') {
            $this->rate = null;
        }

        if($this->hours === '') {
            $this->hours = null;
        }

        return $attributes;
    }
}
