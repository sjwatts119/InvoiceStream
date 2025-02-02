<?php

use App\Livewire\Arrangements\ListArrangements;
use App\Livewire\Arrangements\ShowArrangement;
use App\Livewire\Invoices\ShowInvoice;
use Illuminate\Support\Facades\Route;

Route::name('arrangements.')
    ->group(function () {
        Route::get('/', ListArrangements::class)
            ->middleware(['auth', 'verified'])
            ->name('index');
        Route::get('arrangements/{arrangement}', ShowArrangement::class)
            ->middleware(['auth', 'verified'])
            ->name('show');
});

Route::name('invoices.')
    ->group(function () {
        Route::get('invoices/{invoice}', ShowInvoice::class)
            ->middleware(['auth', 'verified'])
            ->name('show');
    });

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
