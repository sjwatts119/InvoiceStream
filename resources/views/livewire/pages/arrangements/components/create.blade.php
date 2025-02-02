<div>
    <flux:modal.trigger name="create-agreement">
        <flux:button variant="primary" icon="plus">New</flux:button>
    </flux:modal.trigger>

    <form wire:submit="store">
        <flux:modal name="create-agreement" class="max-sm:min-w-[21rem] min-w-[40rem] space-y-6">
            <div>
                <flux:heading size="lg">New Arrangement</flux:heading>
            </div>

            <x-arrangements.form.fields />

            <x-profile.address.form.fields />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Create</flux:button>
            </div>
        </flux:modal>
    </form>
</div>
