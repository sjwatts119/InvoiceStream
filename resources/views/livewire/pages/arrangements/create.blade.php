<div>
    <flux:modal.trigger name="create-agreement">
        <flux:button variant="primary" icon="plus">New</flux:button>
    </flux:modal.trigger>

    <form wire:submit="store">
        <flux:modal name="create-agreement" class="md:w-96 space-y-6">
            <div>
                <flux:heading size="lg">New Arrangement</flux:heading>
            </div>

            <div class="space-y-4">
                <flux:field>
                    <flux:label badge="Required">Name</flux:label>

                    <flux:input required wire:model.live.blur="form.name" />

                    <flux:error name="form.name" />
                </flux:field>
                <flux:textarea wire:model.live.blur="form.description"
                               label="Description" />

                <flux:field>
                    <flux:label badge="Required">Currency</flux:label>

                    <flux:select
                        variant="listbox"
                        placeholder="Currency"
                        required
                        wire:model="form.currency"
                    >
                        @foreach(\Cknow\Money\Money::getISOCurrencies() as $currency)
                            <flux:option>
                                {{ $currency['alphabeticCode'] }}
                            </flux:option>

                        @endforeach
                    </flux:select>

                    <flux:error name="form.currency" />
                </flux:field>


                <flux:input label="Rate" placeholder="Rate per hour" wire:model="form.rate"/>
            </div>

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Create</flux:button>
            </div>
        </flux:modal>
    </form>
</div>
