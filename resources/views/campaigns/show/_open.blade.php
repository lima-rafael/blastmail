<div class="space-y-4">
    <x-form :action="route('campaigns.show', ['campaigns' => $campaigns, 'what' => $what])" get>
        <x-input.text name="search" :placeholder="__('Search an email...')" class="w-full" :value="$search" />
    </x-form>
    <x-table :headers="[__('Name'), __('# Openigns'), __('Email')]">
        <x-slot name="body">
            @foreach ($query as $item)
                <tr>
                    <x-table.td>{{ $item->subscriber->name }}</x-table.td>
                    <x-table.td>{{ $item->openings }}</x-table.td>
                    <x-table.td>{{ $item->subscriber->email }}</x-table.td>
                </tr>
            @endforeach
        </x-slot>
    </x-table>
    {{ $query->links() }}
</div>
