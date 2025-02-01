<?php

namespace App\Livewire\Arrangements;

use App\Livewire\Forms\ArrangementForm;
use App\Models\Arrangement;
use Flux\Flux;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateArrangementModal extends Component
{
    public ArrangementForm $form;

    public function store(): Arrangement
    {
        $this->form->validate();

        $arrangement = auth()->user()
            ->arrangements()
            ->create($this->form->toArray());

        Flux::toast(
            text: 'Arrangement created successfully',
            variant: 'success',
        );
        Flux::modal('create-agreement')->close();
        $this->dispatch('agreement-created');

        return $arrangement;

    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.pages.arrangements.create');
    }
}
