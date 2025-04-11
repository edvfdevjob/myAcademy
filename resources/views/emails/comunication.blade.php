@component('mail::message')
# {{ $title }}

{{ $messageBody }}

@component('mail::button', ['url' => $link])
Ir a la aplicación
@endcomponent

Saludos Cordiales,<br>
{{ config('app.name') }}
@endcomponent