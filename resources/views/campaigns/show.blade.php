<x-layout.app>
    <x-slot name="header">
        <x-h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{ route('campaigns.index') }}">{{ __('Campaigns') }}</a> > {{ $campaigns->name }} > {{ __(str($what)->title()->toString) }}
        </x-h2>
    </x-slot>

    <div class="py-12">
        <x-card>
            <div> {{ $campaigns->descriptions }} </div>
                <x-tabs :tabs="[
                    __('Statistics') => route('campaigns.show', ['campaigns' => $campaigns->id, 'what' => 'statistics']),
                    __('Open') => route('campaigns.show', ['campaigns' => $campaigns->id, 'what' => 'open']),
                    __('Clicked') => route('campaigns.show', ['campaigns' => $campaigns->id, 'what' => 'clicked']),
                ]">

                @include("campaigns.show._{$what}")

                </x-tabs>
        </x-card>
    </div>
</x-layout.app>
