<?php

use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use App\Livewire\Forms\AddressForm;

new class extends Component {
    public AddressForm $form;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->form->fill(Auth::user()->address->toArray());
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateAddress(): void
    {
        $user = Auth::user();

        $this->form->validate();

        $user->address()->update($this->form->toArray());

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
{{--        <flux:input :label="__('Name')" wire:model="name" autofocus required autocomplete="name"/>--}}
{{--        <flux:input :label="__('Email')" wire:model="email" type="email" required autocomplete="username"/>--}}

        <flux:input :label="__('Line 1')" wire:model="form.line_1" required/>
        <flux:input :label="__('Line 2')" wire:model="form.line_2"/>
        <flux:input :label="__('City')" wire:model="form.city" required/>
        <flux:input :label="__('Country')" wire:model="form.country" required/>
        <flux:input :label="__('Postal Code')" wire:model="form.postal_code" required/>

        <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>
    </form>
</section>
