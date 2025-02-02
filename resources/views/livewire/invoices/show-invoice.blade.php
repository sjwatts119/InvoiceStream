<div>
    <flux:button wire:click="download">
        Download
    </flux:button>
    <flux:button wire:click="destroy">
        Delete
    </flux:button>

    <div class="w-full h-full max-w-[44rem] mx-auto bg-white scale-75 overflow-hidden">
        <template shadowrootmode="closed">
            <x-pdf.invoice :$invoice :address="auth()->user()->address"/>
        </template>
    </div>
</div>
