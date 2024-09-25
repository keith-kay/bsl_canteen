@component('mail::message')
# Canteen Login Pin



Your PIN is: {{ $pin }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent