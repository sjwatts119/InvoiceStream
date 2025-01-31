<?php

namespace App\Livewire\Arrangements;

use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListArrangements extends Component
{
    #[Computed]
    protected function getArrangements(): Collection
    {
        return auth()->user()
            ->arrangements()
            ->withCount('entries')
            ->get();
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.pages.arrangements.index')
            ->with('arrangements', $this->getArrangements);
    }
}
