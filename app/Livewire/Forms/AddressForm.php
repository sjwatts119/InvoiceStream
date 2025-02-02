<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class AddressForm extends Form
{
    public ?string $line_1 = '';

    public ?string $line_2 = '';

    public ?string $city = '';

    public ?string $country = '';

    public ?string $postal_code = '';

    public function rules(): array
    {
        return [
            'line_1' => ['required', 'string'],
            'line_2' => ['nullable', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'string'],
            'postal_code' => ['required', 'string'],
        ];
    }
}
