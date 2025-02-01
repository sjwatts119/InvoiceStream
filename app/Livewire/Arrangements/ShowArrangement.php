<?php

namespace App\Livewire\Arrangements;

use App\Livewire\Forms\ArrangementForm;
use App\Models\Arrangement;
use Flux\Flux;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ShowArrangement extends Component
{
    #[Locked, Computed]
    public Arrangement $arrangement;

    public ArrangementForm $form;

    public function mount(): void
    {
        $this->form->fill($this->arrangement->toArray());
    }

    public function update(): void
    {
        $this->authorize('update', $this->arrangement);

        $this->form->validate();

        $this->arrangement->update($this->form->toArray());

        Flux::toast(
            text: 'Arrangement updated successfully',
            variant: 'success',
        );
    }

    public function destroy(): void
    {
        $this->authorize('delete', $this->arrangement);

        $this->arrangement->delete();

        Flux::toast(
            text: 'Arrangement deleted successfully',
            variant: 'success',
        );

        $this->redirect(
            url: route('arrangements.index'),
            navigate:  true,
        );
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.pages.arrangements.show')
            ->with('arrangement', $this->arrangement);
    }
}
