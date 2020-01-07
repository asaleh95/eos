@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
{{ $password }}
@endcomponent

Thanks,<br>
Inspia
{{ config('app.name') }}
@endcomponent
