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

            <flux:heading size="lg">Company Details</flux:heading>

            <flux:field>
                <flux:label badge="Required">Name</flux:label>

                <flux:input required wire:model.live.blur="form.name" />

                <flux:error name="form.name" />
            </flux:field>

            <x-profile.address.form.fields />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Create</flux:button>
            </div>
        </flux:modal>
    </form>
</div>
