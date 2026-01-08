<x-layout.app>
    <x-slot name="header">
        <x-h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Email List') }} > {{ $emailList->id }} > {{ __('Create new subscriber') }}
        </x-h2>
    </x-slot>

    <div class="py-12">
        <x-card>
            <x-form :action="route('subscribers.create', $emailList)" post class="space-y-4">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-input.text id="name" class="block mt-1 w-full" name="name" :value="old('name')" autofocus/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-input.text id="email" class="block mt-1 w-full" name="email" :value="old('email')" autofocus/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center space-x-4">
                    <x-button.link secondary :href="route('subscribers.index', $emailList)">
                        {{ __('Cancel') }}
                    </x-button.link>
                    <x-button type="submit">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </x-form>
        </x-card>
    </div>
</x-layout.app>
