@extends('layouts.app')
@section('title', 'Pengaturan Jabatan / Jabatan')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h2>Pengaturan Jabatan</h2>
                @if ($errors->any())
                    <p class="text-danger">{{ $errors->first() }}</p>
                @endif
                <form action="{{ url('pengguna/pengaturan/jabatan/tambah') }}" class="forms-sample mt-4" method="post">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="position">Jabatan</label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror" name="position" id="position"  value="{{ old('position') }}" placeholder="Jabatan">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="role">peran</label>
                                <input type="text" class="form-control @error('role') is-invalid @enderror" name="role" id="role"  value="{{ old('role') }}" placeholder="peran">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                        <a class="btn btn-light" href="{{ url('pengguna/pengaturan/jabatan') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
