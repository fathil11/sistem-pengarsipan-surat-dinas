@extends('layouts.app')
@section('title')
Buat Surat {{ Str::ucfirst($mail_kind) }}
@endsection
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="mt-3" action="/surat/{{ $mail_kind }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="judul-surat">Judul Surat</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                                    id="judul-surat" placeholder="Judul surat ...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="judul-surat">Instansi</label>
                                <input type="text" class="form-control" name="origin" value="{{ old('origin') }}"
                                    id="instansi" placeholder="Instansi ...">
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->isTU() && $mail_kind == 'masuk')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="judul-surat">Nomor Surat</label>
                                <input type="text" class="form-control" name="code" value="{{ old('code') }}"
                                    id="judul-surat" placeholder="Nomor surat ...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="judul-surat">Nomor Agenda</label>
                                <input type="text" class="form-control" name="directory_code"
                                    value="{{ old('directory_code') }}" id="instansi" placeholder="Nomor agenda ...">
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Jenis Surat</label>
                                <select name="mail_type_id" class="form-control">
                                    <option value="1">- Pilih jenis surat -</option>
                                    @foreach ($mail_extra['type'] as $type)
                                    <option value="{{ $type->id }}">
                                        {{ Str::ucfirst($type->type) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Sifat Surat</label>
                                <select name="mail_reference_id" class="form-control">
                                    <option value="1">- Pilih sifat surat -</option>
                                    @foreach ($mail_extra['reference'] as $type)
                                    <option value="{{ $type->id }}">
                                        {{ Str::ucfirst($type->type) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Prioritas Surat</label>
                                <select name="mail_priority_id" class="form-control">
                                    <option value="1">- Pilih prioritas surat -</option>
                                    @foreach ($mail_extra['priority'] as $type)
                                    <option value="{{ $type->id }}">
                                        {{ Str::ucfirst($type->type) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Folder Surat</label>
                                <select name="mail_folder_id" class="form-control">
                                    <option value="1">- Pilih folder surat -</option>
                                    @foreach ($mail_extra['folder'] as $type)
                                    <option value="{{ $type->id }}">
                                        {{ Str::ucfirst($type->folder) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Waktu Surat</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control datepicker" name="mail_created_at"
                                        placeholder="Waktu surat ..." aria-describedby="basic-addon2"
                                        value="{{ old('created_at') }}">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">File upload</label>
                        <input type="file" name="file" class="file-upload-default"
                            accept=".doc, .docx, .pdf, .png, .jpg, .jpeg">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled
                                placeholder="Upload dokumen disini ...">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-gradient-primary"
                                    type="button">Upload</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <div class="row">
                            <div class="col">
                                <a class="btn btn-block btn-light" href="/surat/keluar">Kembali</a>
                            </div>
                            <div class="col">
                                <button type="submit" value="submit"
                                    class="btn btn-block btn-gradient-primary mr-2">Buat Surat</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker3.standalone.min.css') }}">
@endsection
@section('js')
<script src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/js/datepicker-id.js') }}"></script>
<script src="{{ asset('/js/file-upload.js') }}"></script>
<script>
    $(function(){
        $(".datepicker").datepicker({
            format: 'dd MM yyyy',
            language: 'id',
            autoclose: true,
            todayHighlight: true,
        });
    });
</script>
@endsection
