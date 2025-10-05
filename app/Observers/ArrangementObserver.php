<?php

namespace App\Observers;

use App\Models\Arrangement;

class ArrangementObserver
{
    public function deleting(Arrangement $arrangement): void
    {
        $arrangement->address->delete();
    }
}
