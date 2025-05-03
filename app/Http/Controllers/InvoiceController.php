<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice): View
    {
        $invoice->load([
            'entries',
            'arrangement.address',
        ]);

        return view('components.pdf.invoice')
            ->with([
                'address' => auth()->user()->address,
                'invoice' => $invoice,
            ]);
    }
}
