@extends('layouts.app')
@section('title', 'Pengguna')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h2>Pengguna</h2>
                @if ($errors->any())
                <p class="text-danger">{{ $errors->first() }}</p>
                @endif
                <form action="{{ url('pengguna/') }}" class="forms-sample mt-4" method="post" autocomplete="off">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" placeholder="Nama" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip"
                                    name="nip" placeholder="NIP" value="{{ old('nip') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="user_position_id">Jabatan</label>
                                <select class="form-control" id="user_position_id" name="user_position_id">
                                    @forelse ($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->position }}</option>
                                    @empty
                                    <option>Belum ada jabatan</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="user_position_detail_id">Unit Kerja</label>
                                <select class="form-control" id="user_position_detail_id"
                                    name="user_position_detail_id">
                                    <option>- Pilih Unit Kerja -</option>
                                    @forelse ($position_details as $position_detail)
                                    <option value="{{ $position_detail->id }}">{{ $position_detail->position_detail }}
                                    </option>
                                    @empty
                                    <option>Belum ada Unit Kerja</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="user_department_id">Bidang</label>
                                <select class="form-control" id="user_department_id" name="user_department_id">
                                    <option>- Pilih bidang -</option>
                                    @forelse ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->department }}</option>
                                    @empty
                                    <option>Belum ada Bidang</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" placeholder="Username" value="{{ old('username') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Password" value="{{ old('password') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" placeholder="Email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number">Kontak</label>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                    id="phone_number" name="phone_number" placeholder="Kontak WA"
                                    value="{{ old('phone_number') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                        <a class="btn btn-light" href="{{ url('pengguna/lihat') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
