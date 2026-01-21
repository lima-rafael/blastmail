<x-layout.app>
    <x-slot name="header">
        <x-h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Template') }} > {{ $template->name }} > {{ __('Edit template') }}
        </x-h2>
    </x-slot>

    <div class="py-12">
        <x-card>
            <x-form :action="route('template.update', $template)" put flat>
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-input.text id="name" class="block mt-1 w-full" name="name" :value="old('name', $template->name)" autofocus/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="body" :value="__('Body')" />
                    <x-input.richtext class="block mt-1 w-full" name="body" :value="old('body', $template->body)" autofocus/>
                    <x-input-error :messages="$errors->get('body')" class="mt-2" />
                </div>

                <div class="flex items-center space-x-4">
                    <x-button.link secondary href="{{ route('template.index')}}">
                        {{ __("Cancel")}}
                    </x-button.link>
                    <x-button type="submit">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </x-form>
        </x-card>
    </div>
</x-layout.app>
