<?php

namespace App\Http\Controllers;

use App\Models\Arrangement;
use Illuminate\View\View;

class ArrangementController extends Controller
{
    public function show(Arrangement $arrangement): View
    {
        return view('pages.arrangements.show')
            ->with('arrangement', $arrangement);
    }
}
