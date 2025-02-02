<flux:heading size="lg">Company Details</flux:heading>

<flux:field>
    <flux:label badge="Required">Name</flux:label>

    <flux:input required wire:model.live.blur="form.name" />

    <flux:error name="form.name" />
</flux:field>

<flux:field>
    <flux:label badge="Required">Line 1</flux:label>

    <flux:input wire:model="addressForm.line_1" required />

    <flux:error name="addressForm.line_1" />
</flux:field>

<flux:input :label="__('Line 2')" wire:model="addressForm.line_2"/>

<flux:field>
    <flux:label badge="Required">City</flux:label>

    <flux:input wire:model="addressForm.city" required />

    <flux:error name="addressForm.city" />
</flux:field>

<flux:field>
    <flux:label badge="Required">Country</flux:label>

    <flux:input wire:model="addressForm.country" required />

    <flux:error name="addressForm.country" />
</flux:field>

<flux:field>
    <flux:label badge="Required">Postal Code</flux:label>

    <flux:input wire:model="addressForm.postal_code" required />

    <flux:error name="addressForm.postal_code" />
</flux:field>
