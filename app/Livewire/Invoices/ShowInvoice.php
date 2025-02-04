<?php

namespace App\Livewire\Invoices;

use App\Livewire\Forms\InvoiceNotesForm;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ShowInvoice extends Component
{
    #[Locked]
    public Invoice $invoice;

    public InvoiceNotesForm $form;

    public function mount(): void
    {
        $this->form->fill($this->invoice->toArray());
    }

    public function destroy(): void
    {
        $this->authorize('delete', $this->invoice);

        $arrangement = $this->invoice->arrangement;

        DB::transaction(function () {
            $this->invoice->entries()->update(['invoice_id' => null]);

            $this->invoice->delete();
        });

        Flux::toast(
            text: 'Invoice deleted successfully',
            variant: 'success',
        );

        $this->redirect(
            url: route('arrangements.show', $arrangement->id),
            navigate: true
        );
    }

    public function download(): StreamedResponse
    {
        $this->authorize('view', $this->invoice);

        $this->invoice->load([
            'entries',
            'arrangement.address',
        ]);

        $pdf = Pdf::loadView('components.pdf.invoice', [
            'address' => auth()->user()->address,
            'invoice' => $this->invoice,
        ]);

        return response()->streamDownload(
            callback: function () use ($pdf) {
                echo $pdf->stream();
            },
            name: "Invoice {$this->invoice->short_ulid}.pdf");
    }

    public function update(): void
    {
        $this->authorize('update', $this->invoice);

        $this->form->validate();

        $this->invoice->update($this->form->toArray());

        Flux::toast(
            text: 'Invoice updated successfully',
            variant: 'success',
        );

        Flux::modal('update-invoice')->close();

        $this->redirect(
            url: route('invoices.show', $this->invoice->id),
            navigate: true
        );
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.invoices.show-invoice');
    }
}
