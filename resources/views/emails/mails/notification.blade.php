@component('mail::message')
# Notifikasi Surat
<p>Ada surat yang perlu ditanggapi</p>
<p> <b>Judul</b> : {{ $mail->title }}</p>
<p> <b>Instansi</b> : {{ $mail->origin }}</p>
<p> <b>Jenis</b> : {{ $mail->type->type }}</p>
<p> <b>Sifat</b> : {{ $mail->reference->type }}</p>
<p> <b>Prioritas</b> : {{ $mail->priority->type }}</p>

@component('mail::button', ['url' => 'www.sipas.dinkesmelawi.com'])
Lihat Surat
@endcomponent

Mohon untuk tidak membalas email notifikasi ini.
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent
