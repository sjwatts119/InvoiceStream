<?php

use App\Http\Middleware\Permitted;
use App\Livewire\Arrangements\ListArrangements;
use App\Livewire\Arrangements\ShowArrangement;
use App\Livewire\Invoices\ShowInvoice;
use App\Models\Invoice;
use Illuminate\Support\Facades\Route;

Route::name('arrangements.')
    ->group(function () {
        Route::get('/', ListArrangements::class)
            ->middleware(['auth', 'verified', Permitted::class])
            ->name('index');
        Route::get('arrangements/{arrangement}', ShowArrangement::class)
            ->middleware(['auth', 'verified', 'can:view,arrangement', Permitted::class])
            ->name('show');
    });

Route::name('invoices.')
    ->group(function () {
        Route::get('invoices/{invoice}', ShowInvoice::class)
            ->middleware(['auth', 'verified', 'can:view,invoice', Permitted::class])
            ->name('show');

        Route::get('invoices/{invoice}/preview', [
            function (Invoice $invoice) {
                $invoice->load([
                    'entries' => fn ($query) => $query->orderByDesc('date'),
                    'arrangement.address',
                ]);

                return view('components.pdf.invoice', [
                    'address' => auth()->user()->address,
                    'invoice' => $invoice,
                ]);
            },
        ])
            ->middleware(['auth', 'verified', 'can:view,invoice', Permitted::class])
            ->name('preview');
    });

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
