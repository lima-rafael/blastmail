<x-layout.app>
    <x-slot name="header">
        <x-h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Campaigns') }}
        </x-h2>
    </x-slot>

    <div class="py-12">
        <x-card class="space-y-4">
            <div class="flex justify-between">
                <x-button.link :href="route('campaigns.create')">
                    {{ __('Add a new campaigns') }}
                </x-button.link>
                <x-form :action="route('campaigns.index', $campaigns)" class="w-3/5 flex space-x-4 items-center" x-data x-ref="form">
                    <x-input.checkbox name="showTrash" value="1" :label="__('Show Deleted Records')" @click="$refs.form.submit()"
                        :checked="$showTrash" />
                    <x-input.text name="search" :placeholder="__('Search')" class="w-full" :value="$search" />
                </x-form>
            </div>
            <x-table :headers="['#', __('Name'), __('Actions')]">
                <x-slot name="body">
                    @foreach ($campaigns as $Campaigns)
                        <tr>
                            <x-table.td class="w-1">{{ $Campaigns->id }}</x-table.td>
                            <x-table.td>{{ $Campaigns->name }}</x-table.td>
                            <x-table.td class="w-1">
                                <div class="flex items-center gap-4">
                                    @unless ($Campaigns->trashed())
                                        <x-form :action="route('campaigns.destroy', [$Campaigns])" delete>
                                            <x-button.secondary type="submit"
                                                onclick="return confirm('{{ __('Are you sure?') }}')">
                                                {{ __('Delete') }}
                                            </x-button.secondary>
                                        </x-form>
                                    @else
                                        <x-form :action="route('campaigns.restore', [$Campaigns])" patch>
                                            <x-button.secondary danger type="submit"
                                                onclick="return confirm('{{ __('Are you sure?') }}')">
                                                {{ __('Restore') }}
                                            </x-button.secondary>
                                        </x-form>
                                        <x-badge danger>{{ __('Deleted') }}</x-badge>
                                    @endunless
                                </div>
                            </x-table.td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
            {{ $campaigns->links()}}
        </x-card>
    </div>
</x-layout.app>
