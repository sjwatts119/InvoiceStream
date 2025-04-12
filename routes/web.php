<?php

use App\Livewire\Arrangements\ListArrangements;
use App\Livewire\Arrangements\ShowArrangement;
use App\Livewire\Invoices\ShowInvoice;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;

Route::name('arrangements.')
    ->group(function () {
        Route::get('/', ListArrangements::class)
            ->middleware(['auth', 'verified'])
            ->name('index');
        Route::get('arrangements/{arrangement}', ShowArrangement::class)
            ->middleware(['auth', 'verified', 'can:view,arrangement'])
            ->name('show');
    });

Route::name('invoices.')
    ->group(function () {
        Route::get('invoices/{invoice}', ShowInvoice::class)
            ->middleware(['auth', 'verified', 'can:view,invoice'])
            ->name('show');

        Route::get('invoices/{invoice}/preview', [
            function (Invoice $invoice) {
                $invoice->load([
                    'entries',
                    'arrangement.address',
                ]);

                return view('components.pdf.invoice', [
                    'address' => auth()->user()->address,
                    'invoice' => $invoice,
                ]);
            },
        ])
            ->middleware(['auth', 'verified', 'can:view,invoice'])
            ->name('preview');
    });

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
