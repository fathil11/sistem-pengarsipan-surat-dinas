@extends('layouts.app')
@section('title', 'Pengaturan Surat / Prioritas Surat')
@section('add')
<span><a class="btn btn-secondary p-2" href="{{ url('surat/pengaturan/prioritas-surat/tambah') }}">+ Tambah</a></span>
@endsection
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive p-1">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Prioritas Surat</th>
                                <th>Kode</th>
                                <th>Preview</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mail_priorities as $key=>$mail_priority)
                            <tr>
                                <td>
                                    <div>{{ ++$key }}</div>
                                </td>
                                <td>
                                    <div class="text-wrap">
                                        <h6>{{ $mail_priority->type }}</h6>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-wrap">
                                        <h6>{{ $mail_priority->code }}</h6>
                                    </div>
                                </td>
                                <td>
                                    <label class="badge text-white" style="background: {{ $mail_priority->color }}">{{ $mail_priority->code }}</label>
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('surat/pengaturan/prioritas-surat/'.$mail_priority->id) }}" class="btn btn-info p-2"><i class="mdi mdi-border-color menu-icon"></i></a>
                                    <form action="{{ url('surat/pengaturan/prioritas-surat/'.$mail_priority->id) }}" class="d-inline" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger p-2" type="submit"><i class="mdi mdi-delete menu-icon"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <h4>Tidak ada prioritas surat.</h4>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
