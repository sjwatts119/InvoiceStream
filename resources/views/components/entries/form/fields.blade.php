<div class="space-y-4">
    <flux:field>
        <flux:label>
            Rate
        </flux:label>
        <flux:input.group>

            <flux:input.group.prefix>
                {{ $this->form->currency }}
            </flux:input.group.prefix>

            <flux:input placeholder="Rate per hour" />
        </flux:input.group>
    </flux:field>
</div>
