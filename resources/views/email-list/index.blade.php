<x-layout.app>
    <x-slot name="header">
        <x-h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Email List') }}
        </x-h2>
    </x-slot>

    <div class="py-12">
        <x-card>
            @forelse ($emailLists as $list)
                // Fazer a lista
            @empty
                <div class="flex justify-center">
                    <x-link-button :href="route('email-list.create')">
                        {{ __('Create your first email list') }}
                    </x-link-button>
                </div>
            @endforelse
        </x-card>
    </div>
</x-layout.app>
