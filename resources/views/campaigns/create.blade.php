<x-layout.app>
    <x-slot name="header">
        <x-h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Campaigns') }} > {{ __('Create new campaign') }}
        </x-h2>
    </x-slot>

    <div class="py-12">
        <x-card>
            <x-form :action="route('campaigns.create')" post>
                <x-tabs :tabs="[
                    __('Setup') => route('campaigns.create'),
                    __('Email Body') => route('campaigns.create', ['tab' => 'template']),
                    __('Schedule') => route('campaigns.create', ['tab' => 'schedule']),
                ]">

                @include("campaigns.create.{$form}")

                </x-tabs>

                <div class="flex items-center space-x-4">
                    <x-button.link secondary :href="route('campaigns.index')">
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
