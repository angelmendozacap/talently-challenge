@component('mail::message')
# Welcome {{ $user->name }}

we are glad that you join talently.

@component('mail::button', ['url' => 'https://talently.tech/'])
More about Talently
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
