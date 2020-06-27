@extends('layouts.app')
@section('title', 'Surat Keluar')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Butuh Tindakan</h4>
                <div class="table-responsive p-1">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th> Surat </th>
                                {{-- <th> Instansi </th> --}}
                                <th class="text-center"> Status Surat </th>
                                <th class="text-center"> Surat Diterima </th>
                                <th class="text-center"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mails['incoming'] as $mail)
                            <tr>
                                <td>
                                    <a href="surat-masuk-detail.php" class="text-dark">
                                        <div class="text-wrap">
                                            <h6>{{ $mail->title }}</h6>
                                        </div>
                                        <div>{{ $mail->type }} : {{ $mail->number ?? 'No belum tersedia' }}</div>
                                    </a>
                                </td>
                                {{-- <td class="text-wrap"> {{ $mail->origin }} </td> --}}
                                <td class="text-center">
                                    <label class="badge badge-danger">{{ $mail->status }}</label>
                                </td>
                                <td class="text-center">
                                    {{ Carbon\Carbon::make($mail->created_at)->locale('id_ID')->diffForHumans() }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ $mail->file }}" type="button" class="btn btn-secondary p-2"><i
                                            class="mdi mdi-download menu-icon"></i></a>
                                    <button type="button" class="btn btn-success p-2"
                                        onclick="window.location.href='surat-masuk-teruskan.php'"><i
                                            class="mdi mdi-check menu-icon"></i></button>
                                    <button type="button" class="btn btn-danger p-2"><i
                                            class="mdi mdi-delete menu-icon"></i></button>
                                </td>
                            </tr>
                            @empty
                            <h4>Tidak ada surat.</h4>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Menunggu Proses</h4>
                <div class="table-responsive p-1">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th> Surat </th>
                                {{-- <th> Instansi </th> --}}
                                <th class="text-center"> Status Surat </th>
                                <th class="text-center"> Surat Diterima </th>
                                <th class="text-center"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mails['outcoming'] as $mail)
                            <tr>
                                <td>
                                    <a href="surat-masuk-detail.php" class="text-dark">
                                        <div class="text-wrap">
                                            <h6>{{ $mail->title }}</h6>
                                        </div>
                                        <div>{{ $mail->type }} : {{ $mail->number ?? 'No belum tersedia' }}</div>
                                    </a>
                                </td>
                                {{-- <td class="text-wrap"> {{ $mail->origin }} </td> --}}
                                <td class="text-center">
                                    <label class="badge badge-danger">{{ $mail->status }}</label>
                                </td>
                                <td class="text-center">
                                    {{ Carbon\Carbon::make($mail->created_at)->locale('id_ID')->diffForHumans() }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ $mail->file }}" type="button" class="btn btn-secondary p-2"><i
                                            class="mdi mdi-download menu-icon"></i></a>
                                    <button type="button" class="btn btn-success p-2"
                                        onclick="window.location.href='surat-masuk-teruskan.php'"><i
                                            class="mdi mdi-check menu-icon"></i></button>
                                    <button type="button" class="btn btn-danger p-2"><i
                                            class="mdi mdi-delete menu-icon"></i></button>
                                </td>
                            </tr>
                            @empty
                            <h4>Tidak ada surat.</h4>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
