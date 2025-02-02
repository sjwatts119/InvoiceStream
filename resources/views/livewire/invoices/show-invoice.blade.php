<div x-data="{ showPreview: false }">
    <div class="flex max-md:flex-col gap-4 justify-between">
        <flux:heading size="xl" class="mb-4">Invoice: #{{ $invoice->short_ulid }}</flux:heading>

        <div class="flex gap-2">
            <flux:button icon="chevron-left" variant="ghost" :href="route('arrangements.show', $invoice->arrangement)">
                Back
            </flux:button>
            <flux:button wire:click="download">
                Download
            </flux:button>

            <flux:modal.trigger name="delete-invoice">
                <flux:button variant="danger" icon="trash">Delete</flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <flux:button x-on:click="showPreview = !showPreview">
        <span x-show="showPreview">Hide Preview</span>
        <span x-show="!showPreview">Show Preview</span>
    </flux:button>

    <div class="scale-75 origin-top mt-8" x-show="showPreview">
        <div class="w-[56rem] bg-white shadow-lg mx-auto">
            <div class="overflow-hidden">
                <template shadowrootmode="closed">
                    <x-pdf.invoice :$invoice :address="auth()->user()->address"/>
                </template>
            </div>
        </div>
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
