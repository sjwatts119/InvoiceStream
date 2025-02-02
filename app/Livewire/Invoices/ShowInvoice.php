<?php

namespace App\Livewire\Invoices;

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

    public function destroy(): void
    {
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
        $this->invoice->load([
            'entries',
            'arrangement',
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

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.invoices.show-invoice');
    }
}
