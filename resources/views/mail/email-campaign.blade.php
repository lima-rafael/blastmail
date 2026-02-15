<x-mail::message>

{!! $campaigns->body !!}

Thanks,<br>
{{ config('app.name') }}

<img src="{{ route('traking.openings', $mail) }}" style="display: none">
</x-mail::message>
