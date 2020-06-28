@extends('layouts.app')
@section('title')
Arsip Surat
@endsection
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                {{-- <h4 class="card-title"></h4> --}}
                <div class="grid-container">
                    <div class="grid-item" onclick="window.location.href='/surat/arsip/semua'">
                        <div>
                            <img class="folder" src="{{ asset('images/svg/folder.svg') }}" alt="">
                        </div>
                        <div><b>Semua</b></div>
                    </div>
                    @forelse ($years as $year)
                        <div class="grid-item" onclick="window.location.href='/surat/arsip/{{ $year }}'">
                            <div>
                                <img class="folder" src="{{ asset('images/svg/folder.svg') }}" alt="">
                            </div>
                            <div><b>{{ $year }}</b></div>
                        </div>
                    @empty
                        Tidak ada arsip surat
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
