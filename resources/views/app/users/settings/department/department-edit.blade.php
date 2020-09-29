@extends('layouts.app')
@section('title', 'Pengaturan Jabatan / Bidang')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h2>Pengaturan Bidang</h2>
                @if ($errors->any())
                <p class="text-danger">{{ $errors->first() }}</p>
                @endif
                <form action="{{ url('pengguna/pengaturan/bidang/'.$user_department->id) }}" class="forms-sample mt-4"
                    method="post" autocomplete="off">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bidang">Bidang</label>
                                <input type="text" class="form-control @error('department') is-invalid @enderror"
                                    name="department" id="bidang"
                                    value="{{ old('department', $user_department->department) }}" placeholder="Bidang">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="singkatan">Singkatan</label>
                                <input type="text"
                                    class="form-control @error('department_abbreviation') is-invalid @enderror"
                                    name="department_abbreviation" id="singkatan"
                                    value="{{ old('department_abbreviation', $user_department->department_abbreviation) }}"
                                    placeholder="Singkatan">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                        <a class="btn btn-light" href="{{ url('pengguna/pengaturan/bidang') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
