<div class="flex flex-col gap-4">
    <x-alert success noIcon :title="__('Your campaign was sent to '. $query['total_subscribers']) . ' subscribers on the list: ' . $campaigns->emailList->title" />
    <div class="grid grid-cols-3 gap-5">
        <x-dashboard.card :heading="$query['total_openings']" subheading="{{ __('Opens') }}" />
        <x-dashboard.card :heading="$query['unique_openings']" subheading="{{ __('Unique Opens') }}" />
        <x-dashboard.card heading="{{$query['openings_rate']}}%" subheading="{{ __('Opens rate') }}" />
        <x-dashboard.card :heading="$query['total_clicks']" subheading="{{ __('Clicks') }}" />
        <x-dashboard.card :heading="$query['unique_clicks']" subheading="{{ __('Unique Clicks') }}" />
        <x-dashboard.card heading="{{$query['clicks_rate']}}%" subheading="{{ __('Clicks Rate') }}" />
    </div>
</div>