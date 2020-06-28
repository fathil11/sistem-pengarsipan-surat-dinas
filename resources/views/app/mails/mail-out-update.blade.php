@extends('layouts.app')
@section('title')
Koreksi Surat
@endsection
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2>Koreksi Surat</h2>
                <form class="mt-5" action="/surat/keluar/{{ $mail->id }}/koreksi" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="judul-surat">Judul Surat</label>
                                <input type="text" class="form-control" name="title" value="{{ $mail->title }}"
                                    id="judul-surat" placeholder="Judul Surat">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="judul-surat">Instansi</label>
                                <input type="text" class="form-control" name="origin" value="{{ $mail->origin }}"
                                    id="instansi" placeholder="Instansi">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Jenis Surat</label>
                                <select name="mail_type_id" class="form-control">
                                    @foreach ($mail_extra['type'] as $type)
                                    <option value="{{ $type->id }}"
                                        {{ ($mail->mail_type_id == $type->id) ? 'selected' : '' }}>{{ $type->type}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Sifat Surat</label>
                                <select name="mail_reference_id" class="form-control">
                                    @foreach ($mail_extra['reference'] as $type)
                                    <option value="{{ $type->id }}"
                                        {{ ($mail->mail_reference_id == $type->id) ? 'selected' : '' }}>{{ $type->type}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">Prioritas Surat</label>
                                <select name="mail_priority_id" class="form-control">
                                    @foreach ($mail_extra['priority'] as $type)
                                    <option value="{{ $type->id }}"
                                        {{ ($mail->mail_priority_id == $type->id) ? 'selected' : '' }}>{{ $type->type}}
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
                                    @foreach ($mail_extra['folder'] as $type)
                                    <option value="{{ $type->id }}"
                                        {{ ($mail->mail_folder_id == $type->id) ? 'selected' : '' }}>{{ $type->folder}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Waktu Surat Diterima</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control datepicker" name="mail_created_at"
                                        placeholder="Waktu Surat Diterima" aria-label="Waktu Surat Diterima"
                                        aria-describedby="basic-addon2"
                                        value="{{ $mail->created_at->isoFormat('d MMMM Y') }}">
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
                                placeholder="{{ $mail->file->original_name . '.' . $mail->file->type }}">
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
                                    class="btn btn-block btn-gradient-primary mr-2">Simpan
                                    Koreksi
                                    Surat</button>
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
