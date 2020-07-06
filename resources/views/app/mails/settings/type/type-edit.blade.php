@extends('layouts.app')
@section('title', 'Pengaturan Surat / Jenis Surat')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h2>Pengaturan Jenis Surat</h2>
                @if ($errors->any())
                <p class="text-danger">{{ $errors->first() }}</p>
                @endif
                <form action="{{ url('surat/pengaturan/jenis-surat/'.$mail_type->id) }}" class="forms-sample mt-4"
                    method="post">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type">Jenis Surat</label>
                                <input type="text" class="form-control @error('type') is-invalid @enderror" name="type"
                                    id="type" value="{{ old('type', $mail_type->type) }}" placeholder="Jenis Surat">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="code">Kode Label</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                                    id="code" value="{{ old('code', $mail_type->code) }}" placeholder="Kode Label">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="color">Warna Label</label>
                                <input type="color" class="form-control @error('color') is-invalid @enderror p-0"
                                    name="color" id="color" value="{{ old('color', $mail_type->color) }}" name="color">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="preview">Preview</label><br>
                                <label id="preview" class="badge text-white mt-2">Menunggu</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                        <a class="btn btn-light" href="{{ url('surat/pengaturan/jenis-surat') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
            bgcolor = $('#color').val();
            kode = $('#code').val();
            $('#preview').css("background-color",bgcolor);
            $('#preview').html(kode)
        });
        $('body').on('change', 'input[name="color"]', function() {
            bgcolor = $('#color').val();
            $('#preview').css("background-color",bgcolor);
        });
        $('body').on('change', 'input[name="code"]', function() {
            kode = $('#code').val();
            $('#preview').html(kode)
        });
</script>
@endsection
