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
                <div class="table-responsive p-1">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="font-weight-bold">Surat</th>
                                <th class="font-weight-bold">Instansi</th>
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
                                <td class="text-wrap"> {{ $mail->origin }} </td>
                                <td class="text-center">
                                <form
                                    action="/surat/{{ ($mail->kind=='out') ? 'keluar' : 'masuk'}}/{{ $mail->id }}/download"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('post')
                                    <button type="submit" class="btn btn-secondary p-2"><i
                                            class="mdi mdi-download menu-icon"></i></button>
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
