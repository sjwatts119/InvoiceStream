<div>
    <flux:modal.trigger name="create-agreement">
        <flux:button variant="primary" icon="plus">New</flux:button>
    </flux:modal.trigger>

    <form wire:submit="store">
        <flux:modal name="create-agreement" class="md:w-96 space-y-6">
            <div>
                <flux:heading size="lg">New Arrangement</flux:heading>
            </div>

            <x-arrangements.form.fields />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Create</flux:button>
            </div>
        </flux:modal>
    </form>
</div>
