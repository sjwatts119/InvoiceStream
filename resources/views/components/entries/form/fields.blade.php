<div class="space-y-4">
    <flux:input wire:model="form.date" type="date" :max="now()->format('Y-m-d')" label="Date" required />

    <flux:input wire:model="form.hours" label="Hours" icon="clock" required />

    <flux:field>
        <flux:label>
            Rate
        </flux:label>
        <flux:input.group>
            <flux:input.group.prefix>
                {{ $this->arrangement->currency }}
            </flux:input.group.prefix>

            <flux:input wire:model="form.rate" placeholder="Rate per hour" />
        </flux:input.group>

        <flux:error name="form.rate" />
    </flux:field>

    <flux:textarea wire:model="form.notes" label="Notes" rows="3" resize="none"/>
</div>
