@extends('layouts.app')
@section('title', 'Pengaturan Jabatan / Unit Kerja')
@section('add')
<span><a class="btn btn-secondary p-2" href="{{ url('pengguna/pengaturan/unit-kerja/tambah') }}">+ Tambah</a></span>
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
                                <th>Unit Kerja</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user_position_details as $key=>$user_position_detail)
                            <tr>
                                <td>
                                    <div>{{ ++$key }}</div>
                                </td>
                                <td>
                                    <div class="text-wrap">
                                        <h6>{{ $user_position_detail->position_detail }}</h6>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('pengguna/pengaturan/unit-kerja/'.$user_position_detail->id) }}" class="btn btn-info p-2"><i class="mdi mdi-border-color menu-icon"></i></a>
                                    <form action="{{ url('pengguna/pengaturan/unit-kerja/'.$user_position_detail->id) }}" class="d-inline" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger p-2" type="submit"><i class="mdi mdi-delete menu-icon"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <h4>Tidak ada unit kerja.</h4>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
