@props([
    'tabs' => [],
])

<div class="w-full">
	<div class="flex gap-2 overflow-x-auto border-b border-outline dark:border-gray-700">
        @foreach ($tabs as $title => $route)
            @php
                $selected = request()->getUri() == $route;
            @endphp
            <a @class([
                'h-min px-4 py-2 text-sm',
                'font-bold text-indigo-600 border-b-2 border-primary dark:border-indigo-600 dark:text-primary-dark' => $selected,
                'text-on-surface font-medium dark:text-on-surface-dark dark:hover:border-b-outline-dark-strong dark:hover:text-on-surface-dark-strong hover:border-b-2 hover:border-b-outline-strong hover:text-on-surface-strong' => !$selected,
            ]) href="{{ $route }}">{{ $title }}</a>
        @endforeach
		{{-- <button x-on:click="selectedTab = 'groups'" x-bind:aria-selected="selectedTab === 'groups'" x-bind:tabindex="selectedTab === 'groups' ? '0' : '-1'" x-bind:class="selectedTab === 'groups' ? 'font-bold text-primary border-b-2 border-primary dark:border-primary-dark dark:text-primary-dark' : " class="h-min px-4 py-2 text-sm" type="button" role="tab" aria-controls="tabpanelGroups" >Groups</button> --}}
	</div>
	<div class="px-2 py-4 text-on-surface dark:text-on-surface-dark">
        {{ $slot}}
    </div>
</div>
