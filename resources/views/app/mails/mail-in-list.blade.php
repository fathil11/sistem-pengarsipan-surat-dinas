@extends('layouts.app')
@section('title', 'Surat Keluar')
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
                                <th>Surat Masuk</th>
                                <th>Instansi </th>
                                <th class="text-center">Status Surat </th>
                                <th class="text-center">Surat Diterima </th>
                                <th class="text-center">Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mails as $mail)
                            <tr>
                                <td>
                                    <a href="surat-masuk-detail.php" class="text-dark">
                                        <div class="text-wrap">
                                            <h6>{{ $mail->title }}</h6>
                                        </div>
                                        <div>{{ $mail->number ?? 'No belum tersedia' }}</div>
                                    </a>
                                    <label class="badge mt-2"
                                        style="background: {{ $mail->type->color }};">{{ Str::upper($mail->type->code) }}</label>
                                    <label class="badge mt-2"
                                        style="background: {{ $mail->reference->color }};">{{ Str::upper($mail->reference->code) }}</label>
                                    <label class="badge mt-2"
                                        style="background: {{ $mail->priority->color }};">{{ Str::upper($mail->priority->code) }}</label>
                                </td>
                                <td class="text-wrap"> {{ $mail->origin }} </td>
                                <td class="text-center">
                                    <label class="badge badge-{{ $mail->status_color }}">{{ $mail->status }}</label>
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
