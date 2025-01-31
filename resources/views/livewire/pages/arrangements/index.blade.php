<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($arrangements as $arrangement)
            <flux:card class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ $arrangement->name }}</flux:heading>
                    <flux:subheading>{{ $arrangement->entries_count }} Entries</flux:subheading>
                </div>

                <div class="flex gap-2">
                    <flux:button class="w-full">New Entry</flux:button>

                    <flux:button variant="primary" class="w-full" :href="route('arrangements.show', $arrangement)">View</flux:button>
                </div>
            </flux:card>
        @endforeach
    </div>
</div>
