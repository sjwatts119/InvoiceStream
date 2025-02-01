<div class="space-y-8">
    <div class="flex justify-between">
        <flux:heading size="xl">
            Arrangement: {{ $arrangement->name }}
        </flux:heading>

        <flux:modal.trigger name="delete-arrangement">
            <flux:button variant="danger">Delete</flux:button>
        </flux:modal.trigger>
    </div>

    @if($arrangement->entries->isNotEmpty())
        <div class="flex gap-4">
            <flux:card size="sm" class="min-w-60">
                <flux:subheading>Total Earned</flux:subheading>

                <flux:heading size="xl" class="mb-1">
                    @money($arrangement->earned, $arrangement->currency)
                </flux:heading>
            </flux:card>
            <flux:card size="sm" class="min-w-60">
                <flux:subheading>Total Hours</flux:subheading>

                <flux:heading size="xl" class="mb-1">
                    {{ $arrangement->hours }}
                </flux:heading>
            </flux:card>
        </div>

        <flux:table>
            <flux:columns>
                <flux:column>Date</flux:column>
                <flux:column>Hours</flux:column>
                <flux:column>Rate</flux:column>
                <flux:column>Earned</flux:column>
            </flux:columns>

            <flux:rows>
                @foreach($arrangement->entries as $entry)
                    <flux:row>
                        <flux:cell>
                            {{ $entry->date->format('D j M, Y') }}
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
                    </flux:row>
                @endforeach
            </flux:rows>
        </flux:table>
    @endif

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
</div>
