@extends('layouts.app')
@section('title', 'Surat Masuk / Teruskan')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-4 text-primary text-center text-md-left">Informasi Surat</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <td>Nomor Surat</td>
                            <td>:</td>
                            <td>{{ $mail->code ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Judul</td>
                            <td>:</td>
                            <td>{{ $mail->title }}</td>
                        </tr>
                        <tr>
                            <td>Instansi</td>
                            <td>:</td>
                            <td>{{ $mail->origin }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Surat</td>
                            <td>:</td>
                            <td><label class="badge"
                                    style="background: {{ $mail->type->color }};">{{ $mail->type->type }}</label></td>
                        </tr>
                        <tr>
                            <td>Sifat Surat</td>
                            <td>:</td>
                            <td><label class="badge"
                                    style="background: {{ $mail->reference->color }};">{{ $mail->reference->type }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Prioritas Surat</td>
                            <td>:</td>
                            <td><label class="badge"
                                    style="background: {{ $mail->priority->color }};">{{ $mail->priority->type }}</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Surat</td>
                            <td>:</td>
                            <td> {{ $mail->mail_created_at->isoFormat('DD MMMM Y') }}
                            </td>
                        </tr>
                    </table>
                </div>
                <form action="{{ url('surat/masuk/'.$mail->id.'/teruskan') }}" method="post">
                    @csrf
                    @method('post')
                    <div class="mt-5">
                    @if ($errors->any())
                        <p class="text-danger">{{ $errors->first() }}</p>
                    @endif
                    </div>
                    <h2 class="mb-4 text-primary text-center text-md-left">Catatan/Memo</h2>
                    <div class="form-group">
                        <textarea class="form-control" name="memo" id="exampleTextarea1" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <h2 class="mt-5 mb-4 text-primary text-center text-md-left">Teruskan Surat</h2>
                        <ul class="ks-cboxtags p-0">
                            <li><input type="checkbox" id="kepala_dinas" name="target_user" value="Kepala Dinas" checked><label for="kepala_dinas">Kepala Dinas</label></li>
                            <li><input type="checkbox" id="sekretaris" name="target_user" value="Sekretaris Dinas" disabled><label for="sekretaris">Sekretaris</label></li>
                            @forelse ($user_departments as $user_department)
                                <li><input type="checkbox" id="kepala {{ $user_department->department_abbreviation }}" name="target_user" value="{{ $user_department->department_abbreviation }}" disabled><label for="kepala {{ $user_department->department_abbreviation }}">Kepala Bidang {{ $user_department->department_abbreviation }}</label></li>
                            @empty

                            @endforelse

                        </ul>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-gradient-primary mr-2">Teruskan Surat</button>
                            <a class="btn btn-light" href="/surat/masuk/">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#kepala_dinas').attr('checked', 'checked');
        });
    </script>
@endsection
