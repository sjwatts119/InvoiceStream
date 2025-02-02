<?php

namespace App\Livewire\Arrangements\Components;

use App\Livewire\Forms\AddressForm;
use App\Livewire\Forms\ArrangementForm;
use App\Models\Arrangement;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateArrangementModal extends Component
{
    public ArrangementForm $form;

    public AddressForm $addressForm;

    public function store(): Arrangement
    {
        $this->form->validate();
        $this->addressForm->validate();

        $arrangement = null;

        DB::transaction(function () use (&$arrangement) {
            $arrangement = auth()->user()
                ->arrangements()
                ->create($this->form->toArray());

            $arrangement->address()->create($this->addressForm->toArray());
        });

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
        return view('livewire.pages.arrangements.components.create');
    }
}
