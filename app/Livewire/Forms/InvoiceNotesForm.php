<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class InvoiceNotesForm extends Form
{
    public ?string $notes = '';

    public function rules(): array
    {
        return [
            'notes' => ['nullable', 'string', 'max:255'],
        ];
    }
}
