<?php

namespace App\Livewire\Arrangements;

use App\Livewire\Forms\ArrangementForm;
use App\Livewire\Forms\InvoiceForm;
use App\Models\Arrangement;
use App\Models\Entry;
use App\Rules\Arrangement\EnsureNotInvoiced;
use App\Traits\ValidatesEntries;
use Barryvdh\DomPDF\Facade\Pdf;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ShowArrangement extends Component
{
    use ValidatesEntries;

    #[Locked, Computed]
    public Arrangement $arrangement;

    public ArrangementForm $form;

    public InvoiceForm $invoiceForm;

    #[Validate(['nullable', 'string', 'max:500'])]
    public ?string $notes = '';

    public function mount(): void
    {
        $this->form->fill($this->arrangement->toArray());
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

    public function createInvoice(): void
    {
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
        });

        $this->invoiceForm->reset();

        Flux::toast(
            text: 'Invoice created successfully',
            variant: 'success',
        );
    }

    public function update(): void
    {
        $this->authorize('update', $this->arrangement);

        $this->form->validate();

        $this->arrangement->update($this->form->toArray());

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

    #[Layout('layouts.app'), On('entry-created')]
    public function render(): View
    {
        $this->arrangement->load([
            'entries' => fn ($query) => $query->orderByDesc('date'),
            'invoices',
        ]);

        return view('livewire.pages.arrangements.show')
            ->with('arrangement', $this->arrangement);
    }
}
