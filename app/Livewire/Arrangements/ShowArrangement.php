<?php

namespace App\Livewire\Arrangements;

use App\Models\Arrangement;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ShowArrangement extends Component
{
    #[Locked, Computed]
    public Arrangement $arrangement;

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.pages.arrangements.show')
            ->with('arrangement', $this->arrangement);
    }
}
