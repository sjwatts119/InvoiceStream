<?php

namespace App\Livewire\Arrangements;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ListArrangements extends Component
{
    use WithPagination;
    use WithoutUrlPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    protected function getArrangements(): LengthAwarePaginator
    {
        return auth()->user()
            ->arrangements()
            ->search($this->search)
            ->orderByDesc('updated_at')
            ->paginate(9);
    }

    #[Layout('layouts.app'), On('agreement-created')]
    public function render(): View
    {
        return view('livewire.pages.arrangements.index')
            ->with('arrangements', $this->getArrangements());
    }
}
