<?php

namespace App\Livewire\Arrangements\Components;

use App\Livewire\Forms\EntryForm;
use App\Models\Arrangement;
use Flux\Flux;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateEntryModal extends Component
{
    #[Locked]
    public Arrangement $arrangement;

    public EntryForm $form;

    #[On('arrangement-updated')]
    public function fillForm(): void
    {
        $this->form->currency = $this->arrangement->currency;
        $this->form->fill([
            'rate' => $this->arrangement->rate,
        ]);
    }

    public function mount(): void
    {
        $this->fillForm();
    }

    public function store(): void
    {
        $this->form->validate();

        $this->arrangement->entries()->create($this->form->toArray());
        $this->arrangement->touch();

        $this->dispatch('entry-created');

        $this->form->reset();

        Flux::toast(
            text: 'Entry created successfully.',
            variant: 'success',
        );

        Flux::modal('create-entry')->close();
    }

    public function render(): View
    {
        return view('livewire.pages.arrangements.components.create-entry');
    }
}
