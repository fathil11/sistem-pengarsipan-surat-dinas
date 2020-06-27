@extends('layouts.app')
@section('title', 'Pengaturan Jabatan / Jabatan')
@section('add')
<span><a class="btn btn-secondary p-2" href="{{ url('pengguna/pengaturan/jabatan/tambah') }}">+ Tambah</a></span>
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
                                <th>No</th>
                                <th>Jabatan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user_positions as $key=>$user_position)
                            <tr>
                                <td>
                                    <div>{{ ++$key }}</div>
                                </td>
                                <td>
                                    <div class="text-wrap">
                                        <h6>{{ $user_position->position }}</h6>
                                    </div>
                                    <div>{{ $user_position->role }}</div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('pengguna/pengaturan/jabatan/'.$user_position->id) }}" class="btn btn-info p-2"><i class="mdi mdi-border-color menu-icon"></i></a>
                                    <form action="{{ url('pengguna/pengaturan/jabatan/'.$user_position->id) }}" class="d-inline" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger p-2" type="submit"><i class="mdi mdi-delete menu-icon"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <h4>Tidak ada jabatan.</h4>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
