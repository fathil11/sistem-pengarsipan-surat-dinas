@extends('layouts.app')
@section('css')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('title')
Arsip Surat
@endsection
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive p-4">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="font-weight-bold">Surat</th>
                                <th class="font-weight-bold">Instansi</th>
                                <th class="text-center font-weight-bold">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
{{-- <script src="//code.jquery.com/jquery.js"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
@endsection

@push('scripts')
    @if (Route::currentRouteName() == 'mail.archive.all')
    <script>
        $(function(){
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("json.mail.archive.all") }}'
                },
                columns: [
                    { data: 'full-title', name: 'title' },
                    { data: 'origin', name: 'origin' },
                    // { data: 'type', name: 'type' },
                    // { data: 'reference', name: 'reference' },
                    // { data: 'priority', name: 'priority' },
                    // { data: 'folder', name: 'folder' },
                    { data: 'download', name: 'download' },
                ]
            });
        });
    </script>
    @elseif (Route::currentRouteName() == 'mail.archive.mail.in')
    <script>
        $(function(){
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("json.mail.archive.mail.in") }}'
                },
                columns: [
                    { data: 'full-title', name: 'title' },
                    { data: 'origin', name: 'origin' },
                    // { data: 'type', name: 'type' },
                    // { data: 'reference', name: 'reference' },
                    // { data: 'priority', name: 'priority' },
                    // { data: 'folder', name: 'folder' },
                    { data: 'download', name: 'download' },
                ]
            });
        });
    </script>
    @elseif (Route::currentRouteName() == 'mail.archive.mail.out')
    <script>
        $(function(){
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("json.mail.archive.mail.out") }}'
                },
                columns: [
                    { data: 'full-title', name: 'title' },
                    { data: 'origin', name: 'origin' },
                    // { data: 'type', name: 'type' },
                    // { data: 'reference', name: 'reference' },
                    // { data: 'priority', name: 'priority' },
                    // { data: 'folder', name: 'folder' },
                    { data: 'download', name: 'download' },
                ]
            });
        });
    </script>
    @elseif (Route::currentRouteName() == 'mail.archive.year')
    <script>
        $(function(){
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("json.mail.archive.year", collect(request()->segments())->last()) }}'
                },
                columns: [
                    { data: 'full-title', name: 'title' },
                    { data: 'origin', name: 'origin' },
                    // { data: 'type', name: 'type' },
                    // { data: 'reference', name: 'reference' },
                    // { data: 'priority', name: 'priority' },
                    // { data: 'folder', name: 'folder' },
                    { data: 'download', name: 'download' },
                ]
            });
        });
    </script>
    @endif
@endpush


{{-- @extends('layouts.app')
@section('title')
Arsip Surat
@endsection
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive p-1">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th class="font-weight-bold">Surat</th>
                                <th class="font-weight-bold">Instansi</th>
                                <th class="text-center font-weight-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mails as $mail)
                            <tr>
                                <td>
                                    <div class="text-wrap">
                                        <h6>{{ Str::limit($mail->title, 40) }}</h6>
                                    </div>
                                    <div>{{ $mail->code }}</div>
                                    <label class="badge mt-2"
                                        style="background: {{ $mail->type->color }};">{{ Str::upper($mail->type->type) }}</label>
                                    <label class="badge mt-2"
                                        style="background: {{ $mail->reference->color }};">{{ Str::upper($mail->reference->type) }}</label>
                                    <label class="badge mt-2"
                                        style="background: {{ $mail->priority->color }};">{{ Str::upper($mail->priority->type) }}</label>
                                </td>
                                <td class="text-wrap"> {{ $mail->origin }} </td>
                                <td class="text-center">
                                <form
                                    action="/surat/{{ ($mail->kind=='out') ? 'keluar' : 'masuk'}}/{{ $mail->id }}/download"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('post')
                                    <button type="submit" class="btn btn-secondary p-2"><i
                                            class="mdi mdi-download menu-icon"></i></button>
                                </form>
                                </td>
                            </tr>
                            @empty
                            <h4>Tidak ada surat.</h4>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
