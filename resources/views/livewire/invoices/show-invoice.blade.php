<div>
    <div class="flex gap-2">
        <flux:button wire:click="download">
            Download
        </flux:button>

        <flux:modal.trigger name="delete-invoice">
            <flux:button variant="danger" icon="trash">Delete</flux:button>
        </flux:modal.trigger>
    </div>
    
    <div class="w-full h-full max-w-[44rem] mx-auto bg-white scale-75 overflow-hidden">
        <template shadowrootmode="closed">
            <x-pdf.invoice :$invoice :address="auth()->user()->address"/>
        </template>
    </div>

    <form wire:submit="destroy">
        <flux:modal name="delete-invoice" class="min-w-[22rem] space-y-6">
            <div>
                <flux:heading size="lg">Delete invoice?</flux:heading>
                <flux:subheading>
                    <p>
                        Are you sure you want to delete this invoice?
                    </p>
                    <p>
                        This is not reversible and will mark all associated entries as Uninvoiced.
                    </p>
                </flux:subheading>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger">Confirm</flux:button>
            </div>
        </flux:modal>
    </form>
</div>
