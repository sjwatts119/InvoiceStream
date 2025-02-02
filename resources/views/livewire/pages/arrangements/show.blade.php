<div class="space-y-8">
    <div class="flex justify-between">
        <flux:heading size="xl">
            Arrangement: {{ $arrangement->name }}
        </flux:heading>

        <div class="flex gap-2">
            <flux:modal.trigger name="update-arrangement">
                <flux:button icon="pencil">Edit</flux:button>
            </flux:modal.trigger>

            <flux:modal.trigger name="delete-arrangement">
                <flux:button variant="danger" icon="trash">Delete</flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    @if($arrangement->entries->isNotEmpty())
        <div class="flex gap-4">
            <flux:card size="sm" class="min-w-60">
                <flux:subheading>Total Earned</flux:subheading>

                <flux:heading size="xl" class="mb-1">
                    {{ $arrangement->earned }}
                </flux:heading>
            </flux:card>
            <flux:card size="sm" class="min-w-60">
                <flux:subheading>Total Hours</flux:subheading>

                <flux:heading size="xl" class="mb-1">
                    {{ $arrangement->hours }}
                </flux:heading>
            </flux:card>
        </div>
    @endif

    <div class="flex justify-between items-center">
        <flux:heading size="xl">
            Work Entries
        </flux:heading>
        <div class="flex gap-2">
            <flux:button :disabled="empty($invoiceForm->entries)"
                         icon="document-currency-pound"
                         wire:click="createInvoice">
                Create Invoice
            </flux:button>
            <livewire:arrangements.components.create-entry-modal :$arrangement />
        </div>
    </div>

    @if($arrangement->entries->isNotEmpty())
        <flux:card>
            <flux:checkbox.group wire:model.live="invoiceForm.entries">
                <flux:table>
                    <flux:columns>
                        <flux:column>
                            <flux:checkbox.all />
                        </flux:column>
                        <flux:column>Date</flux:column>
                        <flux:column>Notes</flux:column>
                        <flux:column>Hours</flux:column>
                        <flux:column>Rate</flux:column>
                        <flux:column>Earned</flux:column>
                        <flux:column>Status</flux:column>
                    </flux:columns>

                    <flux:rows>
                        @foreach($arrangement->entries as $entry)
                            <flux:row wire:key="entry-{{ $entry->id }}">
                                <flux:cell>
                                    @if(!$entry->invoiced)
                                        <flux:checkbox :value="$entry->id" />
                                    @endif
                                </flux:cell>
                                <flux:cell>
                                    {{ $entry->date->format('D j M, Y') }}
                                </flux:cell>
                                <flux:cell>
                                    <p class="text-wrap">
                                        {{ $entry->notes ?? 'No notes' }}
                                    </p>
                                </flux:cell>
                                <flux:cell>
                                    {{ $entry->hours }}
                                </flux:cell>
                                <flux:cell>
                                    {{ $entry->formatted_rate }} per hour
                                </flux:cell>
                                <flux:cell>
                                    {{ $entry->earned }}
                                </flux:cell>
                                <flux:cell>
                                    <flux:badge size="sm"
                                                inset="top bottom"
                                                :color="$entry->status === 'Invoiced' ? 'green' : 'red'">
                                        {{ $entry->status }}
                                    </flux:badge>
                                </flux:cell>
                            </flux:row>
                        @endforeach
                    </flux:rows>
                </flux:table>
            </flux:checkbox.group>
            <flux:error name="invoiceForm.entries" />
        </flux:card>
    @else
        <flux:heading>
            No work entries have been created for this arrangement.
        </flux:heading>
    @endif

    <flux:heading size="xl">
        Generated Invoices
    </flux:heading>

    <div class="flex gap-8">
        @forelse($arrangement->invoices as $invoice)
            <flux:card class="space-y-8">
                <div>
                    <flux:heading size="lg">
                        Invoice: #{{ $invoice->short_ulid }}
                    </flux:heading>

                    <flux:subheading>
                        <p>
                            Total: <span class="font-semibold">{{ $invoice->total }}</span>
                        </p>
                        <p>
                            Hours: <span class="font-semibold">{{ $invoice->hours }}</span>
                        </p>
                        <p>
                            Generated: <span class="font-semibold">{{ $invoice->created_at->format('D j M, Y') }}</span>
                        </p>
                    </flux:subheading>
                </div>

                <div class="w-full">
                    <flux:button :href="route('invoices.show', $invoice->id)" class="w-full">
                        View
                    </flux:button>
                </div>
            </flux:card>
        @empty
            <flux:heading>
                No invoices have been created for this arrangement.
            </flux:heading>
        @endforelse
    </div>

    <flux:heading size="xl">
        Arrangement Notes
    </flux:heading>

    <flux:textarea class="rounded-xl"
                   wire:model.blur="notes"
                   placeholder="Any notes go here..."/>
    <flux:error name="notes" />

    <form wire:submit="destroy">
        <flux:modal name="delete-arrangement" class="min-w-[22rem] space-y-6">
            <div>
                <flux:heading size="lg">Delete arrangement?</flux:heading>
                <flux:subheading>
                    <p>
                        Are you sure you want to delete this arrangement?
                    </p>
                    <p>
                        This will also delete any associated entries.
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

    <form wire:submit="update">
        <flux:modal name="update-arrangement" class="md:w-96 space-y-6">
            <div>
                <flux:heading size="lg">Editing Arrangement</flux:heading>
            </div>

            <x-arrangements.form.fields />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Update</flux:button>
            </div>
        </flux:modal>
    </form>
</div>
