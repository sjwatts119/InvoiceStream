<?php

use App\Livewire\Arrangements\ListArrangements;
use Illuminate\Support\Facades\Route;

Route::get('/', ListArrangements::class)
    ->middleware(['auth', 'verified'])
    ->name('arrangements.index');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
