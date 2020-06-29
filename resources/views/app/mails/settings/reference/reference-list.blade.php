@extends('layouts.app')
@section('title', 'Pengaturan Surat / Sifat Surat')
@section('add')
<span><a class="btn btn-secondary p-2" href="{{ url('surat/pengaturan/sifat-surat/tambah') }}">+ Tambah</a></span>
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
                                <th>Sifat Surat</th>
                                <th>Kode</th>
                                <th>Preview</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mail_references as $key=>$mail_reference)
                            <tr>
                                <td>
                                    <div>{{ ++$key }}</div>
                                </td>
                                <td>
                                    <div class="text-wrap">
                                        <h6>{{ $mail_reference->type }}</h6>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-wrap">
                                        <h6>{{ $mail_reference->code }}</h6>
                                    </div>
                                </td>
                                <td>
                                    <label class="badge text-white" style="background: {{ $mail_reference->color }}">{{ $mail_reference->code }}</label>
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('surat/pengaturan/sifat-surat/'.$mail_reference->id) }}" class="btn btn-info p-2"><i class="mdi mdi-border-color menu-icon"></i></a>
                                    <form action="{{ url('surat/pengaturan/sifat-surat/'.$mail_reference->id) }}" class="d-inline" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger p-2" type="submit"><i class="mdi mdi-delete menu-icon"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <h4>Tidak ada sifat surat.</h4>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
