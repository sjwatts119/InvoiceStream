<div>
    <div class="flex justify-between">
        showing arrangement: {{ $arrangement->name }}

        <flux:modal.trigger name="delete-arrangement">
            <flux:button variant="danger">Delete</flux:button>
        </flux:modal.trigger>
    </div>
    <flux:table>
        <flux:columns>
            <flux:column>Date</flux:column>
            <flux:column>Earned</flux:column>
        </flux:columns>

        <flux:rows>
            @foreach($arrangement->entries as $entry)
                <flux:row>
                    <flux:cell>
                        {{ $entry->date->format('D j M, Y') }}
                    </flux:cell>
                    <flux:cell>
                        {{ $entry->earned }}
                    </flux:cell>
                </flux:row>
            @endforeach
        </flux:rows>
    </flux:table>

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
