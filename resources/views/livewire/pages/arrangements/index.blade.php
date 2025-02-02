<div class="space-y-8">
    <div class="flex gap-4">
        <div class="flex-grow">
            <flux:input
                type="search"
                placeholder="Search arrangements..."
                wire:model.live="search"
            />
        </div>
        <livewire:arrangements.components.create-arrangement-modal />
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @foreach($arrangements as $arrangement)
            <flux:card class="space-y-6">
                <div class="space-y-1">
                    <flux:heading size="lg">
                        {{ $arrangement->name }}
                    </flux:heading>
                    <div class="space-y-4 dark:text-zinc-300">
                        <p class="italic text-sm">
                            {{ $arrangement->description ?? 'No Description' }}
                        </p>
                        <div>
                            <p class="text-sm">
                                Total: <span class="font-semibold">{{ $arrangement->earnings }}</span>
                            </p>
                            <p class="text-sm">
                                Hours: <span class="font-semibold">{{ $arrangement->hours }}</span>
                            </p>
                            <p class="text-sm">
                                Generated: <span class="font-semibold">{{ $arrangement->created_at->format('D j M, Y') }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <flux:button variant="primary"
                             class="w-full"
                             :href="route('arrangements.show', $arrangement)">
                    View
                </flux:button>
            </flux:card>
        @endforeach
    </div>
    <div>
        {{ $arrangements->links() }}
    </div>
</div>
