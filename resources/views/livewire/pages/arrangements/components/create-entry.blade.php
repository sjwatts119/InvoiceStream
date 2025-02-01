<div>
    <flux:modal.trigger name="create-entry">
        <flux:button variant="primary" icon="plus">
            Add Entry
        </flux:button>
    </flux:modal.trigger>

    <form wire:submit="store">
        <flux:modal name="create-entry" class="md:w-96 space-y-6">
            <div>
                <flux:heading size="lg">New Work Entry</flux:heading>
            </div>

            <x-entries.form.fields />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Create</flux:button>
            </div>
        </flux:modal>
    </form>
</div>
