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
                <div class="row">
                    <div class="col">
                        <form action="/surat/{{ ($mail->kind == 'in') ? 'masuk' : 'keluar' }}/{{$mail->id}}/download"
                            method="post">
                            @csrf
                            <button type="submit" class="btn btn-block btn-gradient-primary mt-5"><i
                                    class="mdi mdi-download"></i>
                                Unduh Surat</button>
                        </form>
                    </div>
                    @if ($mail->kind == 'in')
                    @if (($mail->transaction == 'outcome' && Auth::user()->isKepalaDinas()) || ($mail->transaction ==
                    'income' && $mail->status['type'] == 'disposition'))
                    <div class="col">
                        <form action="/surat/masuk/{{$mail->id}}/download-disposisi" method="post">
                            @csrf
                            @method('patch')
                            <button type="submit" class="btn btn-block btn-gradient-danger mt-5"><i
                                    class="mdi mdi-download"></i>
                                Unduh Disposisi Surat</button>
                        </form>
                    </div>
                    @endif
                    @endif
                </div>
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
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5>Jenis Kesalahan</h5>
                        <p>{{ $mail->correction->mailCorrectionType->type }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Catatan Kesalahan</h5>
                        <p>{{ $mail->correction->note }}</p>
                    </div>
                </div>
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


@if (Auth::user()->isTU())
<div class="row" id="beri-nomor">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-3 text-primary text-center text-md-left">Nomor Surat Keluar</h2>
                <form action="/surat/keluar/{{ $mail->id }}/buat-nomor" method="POST" autocomplete="off">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        @if ($mail->code != null)
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Nomor Surat</label>
                                <input class="form-control" type="text" name="code" value="{{ $mail->code }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Nomor Agenda</label>
                                <input class="form-control" type="text" name="directory_code"
                                    value="{{ $mail->directory_code }}">
                            </div>
                        </div>
                        @else
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Nomor Surat</label>
                                <input class="form-control" placeholder="Nomor surat ..." type="text" name="code"
                                    value="{{ old('code') }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Nomor Agenda</label>
                                <input class="form-control" placeholder="Nomor agenda ..." type="text"
                                    name="directory_code" value="{{ old('directory_code') }}">
                            </div>
                        </div>

                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit"
                                class="btn btn-block btn-gradient-primary">{{ ($mail->code != null) ? 'Ubah' : 'Masukan' }}
                                Nomor</button>
                        </div>
                        @if ($mail->code != null)
                        <div class="col-md-6" id="archive">
                            <a class="btn btn-block btn-gradient-warning" href="/surat/keluar/{{ $mail->id }}/arsip">
                                Arsipkan Surat
                            </a>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@if($mail->transaction == 'income' && ($mail->status['status'] == 'Perlu Tanggapan'))
<div class="row" id="buat-koreksi">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-3 text-primary text-center text-md-left">Masukan Koreksi
                    Surat</h2>
                <form action="/surat/keluar/{{ $mail->transaction_id }}/buat-koreksi" method="POST" autocomplete="off">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Jenis Koreksi</label>
                                <select name="mail_correction_type_id" class="form-control">
                                    <option value="1">-- Jenis Koreksi --</option>
                                    @foreach ($mail_extra['correction_type'] as $type)
                                    <option value="{{ $type->id }}">
                                        {{ $type->type }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Catatan Koreksi</label>
                                <textarea name="note" class="form-control" id="exampleTextarea1" rows="2"
                                    placeholder="Catatan ..."></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block btn-gradient-primary">Koreksi
                        Surat</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col">
        <div class="form-group">
            <a class="btn btn-light" href="/surat/{{ ($mail->kind == 'in') ? 'masuk' : 'keluar' }}">Kembali</a>
        </div>
    </div>
</div>

@endsection
