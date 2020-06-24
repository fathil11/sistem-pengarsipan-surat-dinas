@extends('errors::illustrated-layout')
@section('image')
<div style="background-image:
url('https://cdn.dribbble.com/users/976215/screenshots/6204988/1-01_2x.jpg');
background-size: 90% auto;" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection
@section('title', __('Not Found'))
@section('code', 'Ups, ')
@section('message', __('Halaman tidak ditemukan'))

{{--
https://cdn.dribbble.com/users/1322726/screenshots/5695684/dribbble-3.gif
https://cdn.dribbble.com/users/1355613/screenshots/5915683/404_illustration_2x.jpg
https://cdn.dribbble.com/users/1175431/screenshots/6188233/404-error-dribbble-800x600.gif
https://cdn.dribbble.com/users/1277985/screenshots/8152622/media/967fc46c3da2e42a4bd1f45c81dd625c.png
 --}}
