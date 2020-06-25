@extends('layouts.app')
@section('title', 'Surat Masuk')
@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Surat Keluar</h4>
                <div class="table-responsive p-1">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th> Surat </th>
                                <th> Instansi </th>
                                <th> Status </th>
                                <th> Surat Diterima </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mails as $mail)
                            <tr>
                                <td>
                                    <a href="surat-masuk-detail.php" class="text-dark">
                                        <div class="text-wrap">
                                            <h6>{{ $mail->title }}</h6>
                                        </div>
                                        <div>{{ $mail->type }} : {{ $mail->number }}</div>
                                    </a>
                                </td>
                                <td class="text-wrap"> {{ $mail->origin }} </td>
                                <td>
                                    <label class="badge badge-success">{{ $mail->status }}</label>
                                </td>
                                <td> {{ Carbon\Carbon::make($mail->created_at)->locale('id_ID')->diffForHumans() }}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-secondary p-2"><i
                                            class="mdi mdi-download menu-icon"></i></button>
                                    <button type="button" class="btn btn-success p-2"
                                        onclick="window.location.href='surat-masuk-teruskan.php'"><i
                                            class="mdi mdi-check menu-icon"></i></button>
                                    <button type="button" class="btn btn-danger p-2"><i
                                            class="mdi mdi-delete menu-icon"></i></button>
                                </td>
                            </tr>
                            @empty
                            <h4>Tidak ada surat.</h4>
                            @endforelse

                            {{-- <tr>
                                <td>
                                    <a href="surat-masuk-detail.php" class="text-dark">
                                        <div class="text-wrap">
                                            <h6>Undangan Kepala Bidang Kesehatan Masyarakat</h6>
                                        </div>
                                        <div>Undangan : 18.5.1/UN32.18/TU/2020</div>
                                    </a>
                                </td>
                                <td class="text-wrap"> Dinas Pemberdayaan Masyarakat Desa Kab.Melawi </td>
                                <td>
                                    <label class="badge badge-info">Dibaca</label>
                                </td>
                                <td> Jun 12, 2020 </td>
                                <td>
                                    <button type="button" class="btn btn-secondary p-2"><i
                                            class="mdi mdi-download menu-icon"></i></button>
                                    <button type="button" class="btn btn-success p-2"
                                        onclick="window.location.href='surat-masuk-teruskan.php'"><i
                                            class="mdi mdi-check menu-icon"></i></button>
                                    <button type="button" class="btn btn-danger p-2"><i
                                            class="mdi mdi-delete menu-icon"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="surat-masuk-detail.php" class="text-dark">
                                        <div class="text-wrap">
                                            <h6>Kegiatan Donor Darah</h6>
                                        </div>
                                        <div>Undangan : 18.5.1/UN32.19/TU/2020</div>
                                    </a>
                                </td>
                                <td class="text-wrap"> Dinas Pendidikan dan Kebudayaan Desa Kab.Melawi </td>
                                <td>
                                    <label class="badge badge-warning">Disposisi</label>
                                </td>
                                <td> Jul 25, 2020 </td>
                                <td>
                                    <button type="button" class="btn btn-secondary p-2"><i
                                            class="mdi mdi-download menu-icon"></i></button>
                                    <button type="button" class="btn btn-success p-2"
                                        onclick="window.location.href='surat-masuk-teruskan.php'"><i
                                            class="mdi mdi-check menu-icon"></i></button>
                                    <button type="button" class="btn btn-danger p-2"><i
                                            class="mdi mdi-delete menu-icon"></i></button>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
