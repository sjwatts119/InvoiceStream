<?php

use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use App\Livewire\Forms\AddressForm;

new class extends Component {
    public AddressForm $addressForm;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->addressForm->fill(Auth::user()->address->toArray());
    }

    /**
     * Update the user's address.
     */
    public function updateAddress(): void
    {
        $user = Auth::user();

        $this->addressForm->validate();

        $user->address()->update($this->addressForm->toArray());

        $this->dispatch('address-updated', name: $user->name);

        Flux::toast(
            text: __('Address updated successfully.'),
            variant: 'success',
        );
    }
}; ?>

<section class="space-y-6">
    <div>
        <flux:heading level="2">
            {{ __('Your Address') }}
        </flux:heading>
        <flux:subheading>
            {{ __("Update the address that will be applied to any invoices you generate.") }}
        </flux:subheading>
    </div>

    <form wire:submit="updateAddress" class="space-y-6">
        <x-profile.address.form.fields />

        <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>
    </form>
</section>
