<div x-data="{ showPreview: false }">
    <div class="flex flex-col gap-4 w-full">
        <div class="flex max-md:flex-col gap-4 justify-between">
            <flux:heading size="xl">Invoice: #{{ $invoice->short_ulid }}</flux:heading>

            <div class="flex gap-2">
                <flux:button icon="chevron-left" variant="ghost" :href="route('arrangements.show', $invoice->arrangement)">
                    Back
                </flux:button>

                <flux:button wire:click="download" icon="arrow-down">
                    Download
                </flux:button>

                <flux:modal.trigger name="update-invoice">
                    <flux:button icon="pencil">
                        Edit
                    </flux:button>
                </flux:modal.trigger>

                <flux:modal.trigger name="delete-invoice">
                    <flux:button variant="danger" icon="trash">Delete</flux:button>
                </flux:modal.trigger>
            </div>
        </div>
        <div class="flex">
            <flux:button x-on:click="showPreview = !showPreview">
                <span x-show="showPreview">Hide Preview</span>
                <span x-show="!showPreview">Show Preview</span>
            </flux:button>
        </div>
    </div>

    <div class="mt-8" x-show="showPreview">
        <div class="min-w-[32rem] max-w-[48rem] h-full bg-white shadow-lg mx-auto">
            <div class="overflow-hidden">
                <iframe class="w-full h-screen" src="{{ route('invoices.preview', $invoice) }}" frameborder="0"></iframe>
            </div>
        </div>
    </div>

    <form wire:submit="update">
        <flux:modal name="update-invoice" class="min-w-[21rem] space-y-6">
            <div>
                <flux:heading size="lg">Updating Invoice</flux:heading>
            </div>

            <flux:textarea wire:model="form.notes" label="Notes" />

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">Update</flux:button>
            </div>
        </flux:modal>
    </form>

    <form wire:submit="destroy">
        <flux:modal name="delete-invoice" class="min-w-[21rem] space-y-6">
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
