@extends('layouts.app')
@section('title', 'Pengaturan Jabatan / Unit Kerja')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h2>Pengaturan Unit Kerja</h2>
                @if ($errors->any())
                    <p class="text-danger">{{ $errors->first() }}</p>
                @endif
                <form action="{{ url('pengguna/pengaturan/unit-kerja/'.$user_position_detail->id) }}" class="forms-sample mt-4" method="post">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-md-4">
                        <div class="form-group">
                            <label for="unit-kerja">Unit Kerja</label>
                            <input type="text" class="form-control" name="position_detail" id="unit-kerja" value="{{ old('position_detail', $user_position_detail->position_detail) }}" placeholder="Unit Kerja">
                        </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                        <a class="btn btn-light" href="{{ url('pengguna/pengaturan/unit-kerja') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
