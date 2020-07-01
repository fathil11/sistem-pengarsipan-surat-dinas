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
                    <div class="grid-item" onclick="window.location.href='/surat/semua/arsip/semua'">
                        <div>
                            <img class="folder" src="{{ asset('images/svg/folder.svg') }}" alt="">
                        </div>
                        <div><b>Semua</b></div>
                    </div>
                    <div class="grid-item" onclick="window.location.href='/surat/semua/arsip/folder'">
                        <div>
                            <img class="folder" src="{{ asset('images/svg/folder.svg') }}" alt="">
                        </div>
                        <div><b>Folder</b></div>
                    </div>
                    <div class="grid-item" onclick="window.location.href='/surat/semua/arsip/surat-masuk'">
                        <div>
                            <img class="folder" src="{{ asset('images/svg/folder.svg') }}" alt="">
                        </div>
                        <div><b>Surat masuk</b></div>
                    </div>
                    <div class="grid-item" onclick="window.location.href='/surat/semua/arsip/surat-keluar'">
                        <div>
                            <img class="folder" src="{{ asset('images/svg/folder.svg') }}" alt="">
                        </div>
                        <div><b>Surat keluar</b></div>
                    </div>
                    <div class="grid-item" onclick="window.location.href='/surat/semua/arsip/tahun'">
                        <div>
                            <img class="folder" src="{{ asset('images/svg/folder.svg') }}" alt="">
                        </div>
                        <div><b>Tahun</b></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
