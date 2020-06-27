@extends('layouts.app')
@section('title', 'Pengaturan Surat / Folder Surat')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h2>Pengaturan Folder Surat</h2>
                @if ($errors->any())
                    <p class="text-danger">{{ $errors->first() }}</p>
                @endif
                <form action="{{ url('surat/pengaturan/folder-surat/'.$mail_folder->id) }}" class="forms-sample mt-4" method="post">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="folder">Folder Surat</label>
                                <input type="text" class="form-control @error('folder') is-invalid @enderror" name="folder" id="folder" value="{{ old('folder', $mail_folder->folder) }}" placeholder="Folder Surat">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                        <a class="btn btn-light" href="{{ url('surat/pengaturan/folder-surat') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
