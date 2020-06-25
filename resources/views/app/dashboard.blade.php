@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('images/svg/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Surat Masuk <i
                        class="mdi mdi-call-received mdi-24px float-right"></i>
                </h4>
                <h2 class="mb-5">78 <span>surat</span></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('images/svg/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Surat Keluar <i class="mdi mdi-call-made mdi-24px float-right"></i>
                </h4>
                <h2 class="mb-5">54 <span>surat</span></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('images/svg/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Draft Surat <i class="mdi mdi-application mdi-24px float-right"></i>
                </h4>
                <h2 class="mb-5">32 <span>surat</span></h2>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <h4 class="card-title float-left">Statistik Surat</h4>
                    <div id="visit-sale-chart-legend"
                        class="rounded-legend legend-horizontal legend-top-right float-right"></div>
                </div>
                <canvas id="visit-sale-chart" class="mt-4"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Jenis Surat</h4>
                <canvas id="traffic-chart"></canvas>
                <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Status Surat Keluar Terbaru</h4>
                <div class="table-responsive p-1">
                    <table id="dataTable" class="table">
                        <thead>
                            <tr>
                                <th> Status </th>
                                <th> Nomor Surat </th>
                                <th> Judul </th>
                                <th> Pembaruan Terakhir </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label class="badge badge-gradient-success">Selesai</label>
                                </td>
                                <td>
                                    18.5.1/UN32.17/TU/2020
                                </td>
                                <td> Surat Peminjaman Tandu PMI </td>
                                <td> Jun 5, 2020 </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="badge badge-gradient-warning">Proses</label>
                                </td>
                                <td>
                                    18.5.1/UN32.18/TU/2020
                                </td>
                                <td> Undangan Gubernur Kalimantan Barat </td>
                                <td> May 12, 2020 </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="badge badge-gradient-info">Menunggu</label>
                                </td>
                                <td>
                                    18.5.1/UN32.19/TU/2020
                                </td>
                                <td> Kegiatan Donor Darah </td>
                                <td> May 16, 2020 </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="badge badge-gradient-danger">Koreksi</label>
                                </td>
                                <td>
                                    18.5.1/UN32.20/TU/2020
                                </td>
                                <td> Permohonan APD </td>
                                <td> Mar 3, 2020 </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
