<x-layout.app>
    <x-slot name="header">
        <x-h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Template') }} > {{ $template->name }} > {{ __('Edit template') }}
        </x-h2>
    </x-slot>

    <div class="py-12">
        <x-card>
            <div class="flex justify-between items-center">
                <x-h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    <span class="opacity-50">{{ __('Name') }}:</span> {{ $template->name }}
                </x-h2>
                <x-button.link secondary href="{{ route('template.index')}}">
                    {{ __("Back to list")}}
                </x-button.link>
            </div>
            <div class="p-20 border border-gray-300 rounded mt-4 flex justify-center">
                {!! $template->body !!}
            </div>
        </x-card>
    </div>
</x-layout.app>
