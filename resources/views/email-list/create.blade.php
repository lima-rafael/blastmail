<x-layout.app>
    <x-slot name="header">
        <x-h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Email List') }} > {{ __('Create new list') }}
        </x-h2>
    </x-slot>

    <div class="py-12">
        <x-card>
            <x-form :action="route('email-list.create')" post enctype="multipart/form-data">
                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-input.text id="title" class="block mt-1 w-full" name="title" :value="old('title')" autofocus/>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="file" :value="__('File List')" />
                    <x-input.text id="file" class="block mt-1 w-full" accept=".csv" type="file" name="file" autofocus/>
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                </div>

                <div class="flex items-center space-x-4">
                    <x-button.secondary type="reset">
                        {{ __('Cancel') }}
                    </x-button.secondary>
                    <x-button type="submit">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </x-form>
        </x-card>
    </div>
</x-layout.app>
