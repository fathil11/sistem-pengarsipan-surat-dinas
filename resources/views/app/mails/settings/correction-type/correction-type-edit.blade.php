@extends('layouts.app')
@section('title', 'Pengaturan Surat / Tipe Koreksi')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h2>Pengaturan Tipe Koreksi</h2>
                @if ($errors->any())
                    <p class="text-danger">{{ $errors->first() }}</p>
                @endif
                <form action="{{ url('surat/pengaturan/tipe-koreksi/'.$mail_correction_type->id) }}" class="forms-sample mt-4" method="post">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type">Tipe Koreksi</label>
                                <input type="text" class="form-control @error('type') is-invalid @enderror" name="type" id="type" value="{{ old('type', $mail_correction_type->type) }}" placeholder="Tipe Koreksi">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                        <a class="btn btn-light" href="{{ url('surat/pengaturan/tipe-koreksi') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
