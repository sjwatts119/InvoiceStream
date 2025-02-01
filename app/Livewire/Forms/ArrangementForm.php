<?php

namespace App\Livewire\Forms;

use Cknow\Money\Rules\Currency;
use Livewire\Form;

class ArrangementForm extends Form
{
    public string $name = '';

    public ?string $description = null;

    public ?string $rate = null;

    public ?string $currency = null;

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'rate' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', new Currency()],
        ];
    }
}
