@extends('layouts.app')
@section('title')
Daftar Surat {{ ($mail_kind == 'in') ? 'Masuk' : 'Keluar' }}
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
                                <th class="font-weight-bold">Instansi </th>
                                <th class="text-center font-weight-bold">Status Surat </th>
                                <th class="text-center font-weight-bold">Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mails as $mail)
                            <tr>
                                <td>
                                    <a href="/surat/{{ ($mail_kind=='out') ? 'keluar' : 'masuk'}}/{{ $mail->id }}"
                                        class="text-dark">
                                        <div class="text-wrap">
                                            <h6>{{ Str::limit($mail->title, 40) }}</h6>
                                        </div>
                                        <div>{{ $mail->code ?? 'No belum tersedia' }}</div>
                                    </a>
                                    <label class="badge mt-2"
                                        style="background: {{ $mail->type->color }};">{{ Str::upper($mail->type->type) }}</label>
                                    <label class="badge mt-2"
                                        style="background: {{ $mail->reference->color }};">{{ Str::upper($mail->reference->type) }}</label>
                                    <label class="badge mt-2"
                                        style="background: {{ $mail->priority->color }};">{{ Str::upper($mail->priority->type) }}</label>
                                </td>
                                <td class="text-wrap"> {{ $mail->origin }} </td>
                                <td class="text-center">
                                    <label
                                        class="badge badge-{{ $mail->status['color'] }}">{{ $mail->status['status'] }}</label><br>
                                    <span class="text-muted font-weight-lighter badge">
                                        @if ($mail->transaction == 'out')
                                        Dikirim
                                        @else
                                        Diterima
                                        @endif
                                        {{ Carbon\Carbon::make($mail->transaction_time)->diffForHumans() }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form
                                        action="/surat/{{ ($mail_kind=='out') ? 'keluar' : 'masuk'}}/{{ $mail->id }}/download"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-secondary p-2"><i
                                                class="mdi mdi-download menu-icon"></i></button>
                                    </form>
                                    @if(Auth::user()->isTU() && $mail->status['status'] == 'Perlu Tanggapan')
                                    <button type="button" class="btn btn-success p-2"
                                        onclick="window.location.href='/surat/keluar/{{ $mail->id }}/beri-nomor'"
                                        {{ ($mail->transaction == 'outcome' || ($mail->transaction == 'income' && $mail->status['type'] == 'disposition')) ? 'disabled' : ''}}>
                                        <i class="mdi mdi-border-color menu-icon"></i></button>
                                    @elseif ($mail_kind == 'out' && !Auth::user()->isTU())
                                    <form class="d-inline" method="POST"
                                        action="/surat/{{ ($mail_kind=='out') ? 'keluar' : 'masuk'}}/{{ $mail->id }}/teruskan">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success p-2"
                                            {{ ($mail->transaction == 'outcome' || ($mail->transaction == 'income' && $mail->status['type'] == 'disposition')) ? 'disabled' : ''}}><i
                                                class="mdi mdi-check menu-icon"></i></button>
                                    </form>
                                    <button type="button" class="btn btn-info p-2"
                                        onclick="window.location.href='/surat/{{ ($mail_kind=='out') ? 'keluar' : 'masuk'}}/{{ $mail->id }}{{ ($mail->status['status'] == 'Perlu Dikoreksi') ? '/koreksi' : '' }}'"
                                        {{ ($mail->transaction == 'outcome' || ($mail->transaction == 'income' && $mail->status['type'] == 'disposition')) ? 'disabled' : ''}}>
                                        <i class="mdi mdi-border-color menu-icon"></i></button>
                                    @endif
                                    @if ($mail_kind == 'in')
                                        <a href="/surat/{{ ($mail_kind=='in') ? 'masuk' : 'keluar'}}/{{ $mail->id }}/{{ ($mail_kind=='in' && \App\User::with('position')->where('id', Auth::id())->first()->getRole() == 'kepala_dinas') ? 'disposisi' : 'teruskan' }}" class="btn btn-success p-2 {{ ($mail->transaction == 'outcome' || ($mail->transaction == 'income' && $mail->status['type'] == 'disposition')) ? 'disabled' : ''}}"><i
                                            class="mdi mdi-check menu-icon"></i></a>
                                    @endif
                                    <button type="button" class="btn btn-danger p-2"
                                        {{ ($mail->transaction == 'outcome' || ($mail->transaction == 'income' && $mail->status['type'] == 'disposition')) ? 'disabled' : ''}}><i
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
