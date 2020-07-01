@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => 'https://sipas.dinkesmelawi.com'])
Kunjungi Surat
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
