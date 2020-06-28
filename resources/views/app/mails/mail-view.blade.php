@extends('layouts.app')
@section('title')
Detail Surat
@endsection
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-4 text-primary text-center text-md-left">Informasi Surat</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <td>Nomor Surat</td>
                            <td>:</td>
                            <td>{{ $mail->code ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Judul</td>
                            <td>:</td>
                            <td>{{ $mail->title }}</td>
                        </tr>
                        <tr>
                            <td>Instansi</td>
                            <td>:</td>
                            <td>{{ $mail->origin }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Surat</td>
                            <td>:</td>
                            <td><label class="badge"
                                    style="background: {{ $mail->type->color }};">{{ $mail->type->type }}</label></td>
                        </tr>
                        <tr>
                            <td>Sifat Surat</td>
                            <td>:</td>
                            <td><label class="badge"
                                    style="background: {{ $mail->reference->color }};">{{ $mail->reference->type }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Prioritas Surat</td>
                            <td>:</td>
                            <td><label class="badge"
                                    style="background: {{ $mail->priority->color }};">{{ $mail->priority->type }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Surat</td>
                            <td>:</td>
                            <td> {{ $mail->mail_created_at->isoFormat('DD MMMM Y') }}
                            </td>
                        </tr>
                    </table>
                </div>
                <form action="/surat/{{ ($mail->kind == 'in') ? 'masuk' : 'keluar' }}/{{$mail->id}}/download"
                    method="post">
                    @csrf
                    <button type="submit" class="btn btn-block btn-gradient-primary mt-5"><i
                            class="mdi mdi-download"></i>
                        Unduh Surat</button>
                </form>
            </div>
        </div>
    </div>
</div>
@if ($mail->correction != null)
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-2 text-primary text-center text-md-left">Koreksi Surat</h2>
                <p>{{ $mail->correction->type }}</p>
                <p>{{ $mail->correction->note }}</p>
            </div>
        </div>
    </div>
</div>
@endif

@if ($mail->logs != null)
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-3 text-primary text-center text-md-left">Riwayat Surat</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th><b>No</b></th>
                                <th><b>Aksi</b></th>
                                <th><b>Waktu</b></th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($mail->logs as $key => $log)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td>{{ $log->log }} oleh {{ $log->user->name }}</td>
                                <td>{{ $log->created_at->isoFormat('D MMMM Y (HH:mm)') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col">
        <div class="form-group">
            <a class="btn btn-block btn-light"
                href="/surat/{{ ($mail->kind == 'in') ? 'masuk' : 'keluar' }}">Kembali</a>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <a class="btn btn-block btn-warning" href="/surat/{{ ($mail->kind == 'in') ? 'masuk' : 'keluar' }}">Koreksi
                Surat</a>
        </div>
    </div>
</div>

@endsection
