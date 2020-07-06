@extends('layouts.app')
@section('title')
Daftar Surat {{ Request::is('surat/semua/masuk') ? 'Masuk' : 'Keluar' }}
@endsection
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                {{-- <h4 class="card-title"></h4> --}}
                <div class="table-responsive p-1">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="font-weight-bold">Surat</th>
                                <th class="font-weight-bold text-center">Instansi</th>
                                <th class="font-weight-bold text-center">Status</th>
                                <th class="text-center font-weight-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mails as $mail)
                            <tr>
                                <td>
                                    <div class="text-wrap">
                                        <h6>{{ Str::limit($mail->title, 40) }}</h6>
                                    </div>
                                    <div>{{ $mail->code }}</div>
                                    <label class="badge mt-2"
                                        style="background: {{ $mail->type->color }};">{{ Str::upper($mail->type->type) }}</label>
                                    <label class="badge mt-2"
                                        style="background: {{ $mail->reference->color }};">{{ Str::upper($mail->reference->type) }}</label>
                                    <label class="badge mt-2"
                                        style="background: {{ $mail->priority->color }};">{{ Str::upper($mail->priority->type) }}</label>
                                </td>
                                <td class="text-wrap text-center"> {{ $mail->origin }} </td>
                                <td class="text-wrap text-center">
                                    @php
                                    switch($mails[0]->mailVersions->last()->mailTransactions->last()->type){
                                    case 'disposition':
                                    $status = 'Telah Didisposisikan';
                                    $color = 'success';
                                    break;
                                    case 'memo':
                                    $status = 'Sedang di Kepala Dinas';
                                    $color = 'warning';
                                    break;
                                    case 'forward':
                                    $status = 'Sedang Diproses';
                                    $color = 'primary';
                                    break;
                                    default:
                                    $status = $mails[0]->mailVersions->last()->mailTransactions->last()->type;
                                    $color = 'danger';
                                    }
                                    @endphp
                                    <label class="badge badge-{{ $color }}">
                                        {{ $status }}
                                    </label>
                                </td>
                                <td class="text-center">
                                    <form
                                        action="/surat/semua/{{ ($mail->kind=='out') ? 'keluar' : 'masuk'}}/{{ $mail->id }}/download"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('post')
                                        <button type="submit" class="btn btn-secondary p-2"><i
                                                class="mdi mdi-download menu-icon"></i></button>
                                    </form>
                                    <form
                                        action="/surat/{{ ($mail->kind=='out') ? 'keluar' : 'masuk'}}/{{ $mail->id }}/arsip"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning p-2"><i
                                                class="mdi mdi-book-variant menu-icon"></i></button>
                                    </form>
                                    <form action="/surat/{{ $mail->id }}" class="d-inline" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger p-2" type="submit"><i
                                                class="mdi mdi-delete menu-icon"></i></button>
                                    </form>
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
