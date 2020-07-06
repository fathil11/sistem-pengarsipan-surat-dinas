@extends('layouts.app')
@section('title', 'Lihat Pengguna')
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
                                <th>Pengguna</th>
                                <th>Jabatan</th>
                                <th>Akun</th>
                                <th>Kontak</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="text-wrap">
                                        <h6>{{ $user->name }}</h6>
                                    </div>
                                    <div>{{ $user->nip}}</div>
                                </td>
                                <td>
                                    <div class="text-wrap">
                                        <h6>{{ $user->position->position }}</h6>
                                    </div>
                                    <div>{{ $user->department->department_abbreviation ?? '' }}</div>
                                </td>
                                <td>
                                    <div class="text-wrap">
                                        <h6>{{ $user->email }}</h6>
                                    </div>
                                    <div>{{ $user->username }}</div>
                                </td>
                                <td>
                                    <div>{{ $user->phone_number }}</div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ url('pengguna/'.$user->id) }}" class="btn btn-info p-2" type="submit"><i class="mdi mdi-border-color menu-icon"></i></a>
                                    <form action="{{ url('pengguna/'.$user->id) }}" class="d-inline" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger p-2" type="submit"><i class="mdi mdi-delete menu-icon"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <h4>Tidak ada pengguna.</h4>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
