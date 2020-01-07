@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
{{ $code }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
