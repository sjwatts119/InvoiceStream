<div class="space-y-4">
    <flux:field>
        <flux:label badge="Required">Name</flux:label>

        <flux:input required wire:model.live.blur="form.name" />

        <flux:error name="form.name" />
    </flux:field>

    <flux:field>
        <flux:label badge="Required">Currency</flux:label>

        <flux:select
            variant="listbox"
            placeholder="Currency"
            required
            wire:model.live="form.currency"
        >
            @foreach(\Cknow\Money\Money::getISOCurrencies() as $currency)
                <flux:option>
                    {{ $currency['alphabeticCode'] }}
                </flux:option>

            @endforeach
        </flux:select>

        <flux:error name="form.currency" />
    </flux:field>

    <flux:field>
        <flux:label>Rate</flux:label>

        <flux:input.group>
            @if($this->form->currency)
                <flux:input.group.prefix>
                    @currency($this->form->currency)
                </flux:input.group.prefix>
            @endif

            <flux:input placeholder="Rate per hour" wire:model="form.rate" clearable />
        </flux:input.group>

        <flux:error name="form.rate" />
    </flux:field>

    <flux:textarea wire:model.live.blur="form.description"
                   label="Description" />
</div>
