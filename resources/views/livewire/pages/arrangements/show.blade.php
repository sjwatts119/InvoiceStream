<div>
    showing arrangement: {{ $arrangement->name }}
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
</div>
