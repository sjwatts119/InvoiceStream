<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvoicePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Invoice $invoice): Response
    {
        return $user->is($invoice->user)
            ? Response::allow()
            : Response::denyWithStatus('404');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Invoice $invoice): Response
    {
        return $user->is($invoice->user)
            ? Response::allow()
            : Response::denyWithStatus('404');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Invoice $invoice): Response
    {
        return $user->is($invoice->user)
            ? Response::allow()
            : Response::denyWithStatus('404');
    }
}
