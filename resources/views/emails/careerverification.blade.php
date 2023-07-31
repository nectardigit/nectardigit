@component('mail::message')
# Introduction

Hello {{ $name }}. Please Verify your email. Our representative will contact you soon.

@component('mail::button', ['url' => route("career-verification",$verification)])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
