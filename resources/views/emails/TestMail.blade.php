@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => 'https://sipas.dinkesmelawi.com'])
Cek Surat
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
