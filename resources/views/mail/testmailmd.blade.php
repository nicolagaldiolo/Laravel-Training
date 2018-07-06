@component('mail::message')
# Welcome {{$user->name}} {{$user->email}}


The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
