<div>
    <flux:button wire:click="download">
        Download Invoice
    </flux:button>
    <div class="w-full h-full max-w-[44rem] mx-auto bg-white scale-75 overflow-hidden">
        <template shadowrootmode="closed">
            <x-pdf.invoice :$invoice />
        </template>
    </div>
</div>
