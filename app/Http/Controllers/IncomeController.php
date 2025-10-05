<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class IncomeController extends Controller
{
    public function index(): View
    {
        return view('pages.income.index');
    }
}
