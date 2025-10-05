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

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    protected function arrangements(): LengthAwarePaginator
    {
        return auth()->user()
            ->arrangements()
            ->search($this->search)
            ->orderByDesc('updated_at')
            ->paginate(9);
    }

    #[On('agreement-created')]
    public function render(): View
    {
        return view('livewire.pages.arrangements.index');
    }
}
