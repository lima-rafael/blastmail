<x-layout.app>
    <x-slot name="header">
        <x-h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Template List') }}
        </x-h2>
    </x-slot>

    <div class="py-12">
        <x-card class="space-y-4">
            {{-- @unless($templates->isEmpty() && blank($search)) --}}
                <div class="flex justify-between">
                    <x-button.link :href="route('template.create')">
                        {{ __('Add a new template') }}
                    </x-button.link>
                    <x-form :action="route('template.index', $templates)" class="w-3/5 flex space-x-4 items-center" x-data x-ref="form">
                        <x-input.checkbox
                            name="showTrash"
                            value="1"
                            :label="__('Show Deleted Records')"
                            @click="$refs.form.submit()"
                            :checked="$showTrash"
                        />
                        <x-input.text name="search" :placeholder="__('Search')" class="w-full" :value="$search" />
                    </x-form>
                </div>
                <x-table :headers="['#', __('Name'), __('Actions')]">
                    <x-slot name="body">
                        @foreach ($templates as $template)
                            <tr>
                                <x-table.td class="w-1">{{ $template->id }}</x-table.td>
                                <x-table.td>{{ $template->name }}</x-table.td>
                                <x-table.td class="w-1">
                                    <div class="flex items-center gap-4">
                                        @unless ($template->trashed())
                                            <x-form :action="route('template.show', [$template])">
                                                <x-button.secondary type="submit">
                                                    {{ __('preview') }}
                                                </x-button.secondary>
                                            </x-form>
                                            <x-form :action="route('template.edit', [$template])">
                                                <x-button.secondary type="submit">
                                                    {{ __('Edit') }}
                                                </x-button.secondary>
                                            </x-form>
                                            <x-form :action="route('template.destroy', [$template])" delete>
                                                <x-button.secondary type="submit" onclick="return confirm('{{ __('Are you sure?') }}')">
                                                    {{ __('Delete') }}
                                                </x-button.secondary>
                                            </x-form>
                                            @else
                                            <x-badge danger>{{ __('Deleted') }}</x-badge>
                                        @endunless
                                    </div>
                                </x-table.td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-table>
            {{-- @else
                <div class="flex justify-center">
                    <x-button.link :href="route('template.create')">
                        {{ __('Create your first template') }}
                    </x-button.link>
                </div> --}}
            {{-- @endunless --}}
        </x-card>
    </div>
</x-layout.app>
