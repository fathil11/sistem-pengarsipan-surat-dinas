@component('mail::message')
# Notifikasi Surat
Ada surat yang perlu
Judul : Surat untuk om Bambang
Jenis : Undangan
Sifat : Rahasia
Prioritas : Segera

@component('mail::button', ['url' => 'www.sipas.dinkesmelawi.com'])
Lihat Surat
@endcomponent

Mohon untuk tidak membalas email notifikasi ini.
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent
