<?php

namespace App\Livewire\Arrangements;

use App\Livewire\Forms\AddressForm;
use App\Livewire\Forms\ArrangementForm;
use App\Livewire\Forms\InvoiceForm;
use App\Models\Arrangement;
use App\Models\Entry;
use App\Rules\Arrangement\EnsureNotInvoiced;
use App\Traits\ValidatesEntries;
use Flux\Flux;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ShowArrangement extends Component
{
    use ValidatesEntries, WithPagination, WithoutUrlPagination;

    #[Locked, Computed]
    public Arrangement $arrangement;

    public ArrangementForm $form;

    public AddressForm $addressForm;

    public InvoiceForm $invoiceForm;

    public int $rowCount = 10;

    protected int $invoiceCount = 6;

    public string $sortBy = 'date';

    public string $sortDirection = 'desc';

    #[Validate(['nullable', 'string', 'max:500'])]
    public ?string $notes = '';

    public function mount(): void
    {
        $this->form->fill($this->arrangement->toArray());
        if($this->arrangement->address) {
            $this->addressForm->fill($this->arrangement->address->toArray());
        }
        $this->notes = $this->arrangement->notes;
    }

    public function updatedNotes(): void
    {
        $this->validate();

        $this->arrangement->notes = $this->notes;

        $this->arrangement->save();

        Flux::toast(
            text: 'Notes updated successfully',
            variant: 'success',
        );
    }

    public function sort($column): void {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function createInvoice(): void
    {
        if(!$this->arrangement->address()->exists()) {
            Flux::toast(
                text: 'Please add an address to the arrangement before creating an invoice.',
                variant: 'danger',
            );

            return;
        }

        $this->invoiceForm->validate([
            'entries' => [
                ...$this->baseEntryRules(),
                new EnsureNotInvoiced(),
            ],
        ]);

        DB::transaction(function () {
            $invoice = auth()->user()->invoices()->create();

            Entry::whereIn('id', $this->invoiceForm->entries)
                ->update(['invoice_id' => $invoice->id]);

            $this->arrangement->touch();
        });

        $this->invoiceForm->reset();

        Flux::modal('create-invoice')->close();

        Flux::toast(
            text: 'Invoice created successfully',
            variant: 'success',
        );
    }

    public function update(): void
    {
        $this->authorize('update', $this->arrangement);

        $this->form->validate();

        DB::transaction(function () {
            $this->arrangement->update($this->form->toArray());

            $this->arrangement->address()->updateOrCreate(
                attributes: [],
                values: $this->addressForm->toArray()
            );
        });

        $this->dispatch('arrangement-updated');

        Flux::toast(
            text: 'Arrangement updated successfully',
            variant: 'success',
        );

        Flux::modal('update-arrangement')->close();
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

    public function loadMoreInvoices(): void
    {
        $this->invoiceCount += 6;
    }

    protected function getEntries(Arrangement $arrangement): LengthAwarePaginator
    {
        return $arrangement->entries()
            ->tap(function ($query) {
                return $this->sortBy
                    ? $query->orderBy($this->sortBy, $this->sortDirection)
                    : $query;
            })
            ->paginate($this->rowCount);
    }

    public function getInvoices(Arrangement $arrangement): Paginator
    {
        return $arrangement->invoices()
            ->simplePaginate($this->invoiceCount);
    }

    #[Layout('layouts.app'), On('entry-created')]
    public function render(): View
    {
        $this->arrangement->load([
            'invoices' => fn($query) => $query->latest(),
        ]);

        return view('livewire.pages.arrangements.show')
            ->with([
                'arrangement' => $this->arrangement,
                'entries' => $this->getEntries($this->arrangement),
                'invoices' => $this->getInvoices($this->arrangement),
            ]);
    }
}
