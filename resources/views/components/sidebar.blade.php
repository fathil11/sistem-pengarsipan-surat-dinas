<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="row">
                    <div class="col">
                        <div class="nav-profile-text d-flex flex-column">
                            <p class="font-weight-bold mb-2">{{ Str::limit(Auth::user()->name, 20) }}</p>
                            <span class="text-secondary text-small">{{ Auth::user()->position->position }}</span>
                        </div>
                    </div>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="btn btn-block btn-gradient-primary mt-4"
                href="@if (Auth::user()->isTU()) /surat/masuk/buat @else /surat/keluar/buat @endif">
                <span class="menu-title"><span class="mdi mdi-file-plus menu-icon"></span> Buat Surat</span>
                <i class="menu-arrow"></i>
            </a>
            {{-- <div class="collapse" id="add">
                <ul class="nav flex-column sub-menu">
                    @if (Auth::user()->isTU())
                    <li class="nav-item"> <a class="nav-link" href="/surat/masuk/buat">Buat Surat
                            Masuk</a></li>
                    @else
                    <li class="nav-item"> <a class="nav-link" href="/surat/keluar/buat">Buat Surat
                            Keluar</a></li>
                    @endif
                </ul>
            </div> --}}
        </li>
        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
            <a class="nav-link" href="/">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{ Request::is('surat/masuk*') ? 'active' : '' }}">
            <a class="nav-link" href="/surat/masuk">
                <span class="menu-title">Surat Masuk</span>
                <i class="mdi mdi-book-multiple menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{ Request::is('surat/keluar*') ? 'active' : '' }}">
            <a class="nav-link" href="/surat/keluar">
                <span class="menu-title">Surat Keluar</span>
                <i class="mdi mdi-briefcase-check menu-icon"></i>
            </a>
        </li>

        @if (Auth::user()->isAdmin() ||
        Auth::user()->isKepalaDinas() ||
        Auth::user()->isSekretaris() ||
        Auth::user()->isTU())

        <li class="nav-item mt-4">
            <div class="border-bottom">
                <h6 class="font-weight-normal mb-3"><b>Seluruh Surat</b></h6>
            </div>
        </li>
        <li class="nav-item {{ Request::is('surat/semua/masuk') ? 'active' : '' }}">
            <a class="nav-link" href="/surat/semua/masuk">
                <span class="menu-title">Surat Masuk</span>
                <i class="mdi mdi-archive menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{ Request::is('surat/semua/keluar') ? 'active' : '' }}">
            <a class="nav-link" href="/surat/semua/keluar">
                <span class="menu-title">Surat Keluar</span>
                <i class="mdi mdi-archive menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{ Request::is('surat/semua/arsip/*') ? 'active' : '' }}">
            <a class="nav-link" href="/surat/semua/arsip">
                <span class="menu-title">Arsip Surat</span>
                <i class="mdi mdi-archive menu-icon"></i>
            </a>
        </li>
        @endif

        @if (Auth::user()->isAdmin())
        <li class="nav-item sidebar-actions">
            <span class="nav-link">
                <div class="border-bottom">
                    <h6 class="font-weight-normal mb-3"><b>Super Admin Menu</b></h6>
                </div>
            </span>
        </li>
        <li class="nav-item">
            <div class="nav-link text-center">
                <a class="btn btn-block btn-gradient-primary" href="/pengguna">
                    <span class="menu-title">
                        <span class="mdi mdi-account-plus menu-icon">
                        </span>
                        Tambah Pengguna
                    </span>
                </a>
            </div>
        </li>
        <li class="nav-item {{ Request::is('pengguna/lihat') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('pengguna/lihat') }}">
                <span class="menu-title">Lihat Pengguna</span>
                <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>
        </li>
        <li class="nav-item {{ Request::is('pengguna/pengaturan/*') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#jabatan" aria-expanded="false" aria-controls="jabatan">
                <span class="menu-title">Pengaturan Jabatan</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-account-settings menu-icon"></i>
            </a>
            <div class="collapse" id="jabatan">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a
                            class="nav-link {{ Request::is('pengguna/pengaturan/jabatan') ? 'active' : '' }}"
                            href="{{ url('pengguna/pengaturan/jabatan') }}">Jabatan</a></li>
                    <li class="nav-item"> <a
                            class="nav-link {{ Request::is('pengguna/pengaturan/unit-kerja') ? 'active' : '' }}"
                            href="{{ url('pengguna/pengaturan/unit-kerja') }}">Unit Kerja</a>
                    </li>
                    <li class="nav-item"> <a
                            class="nav-link {{ Request::is('pengguna/pengaturan/bidang') ? 'active' : '' }}"
                            href="{{ url('pengguna/pengaturan/bidang') }}">Departemen</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item {{ Request::is('surat/pengaturan/*') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#letter_setting" aria-expanded="false"
                aria-controls="letter_setting">
                <span class="menu-title">Pengaturan Surat</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-settings menu-icon"></i>
            </a>
            <div class="collapse" id="letter_setting">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a
                            class="nav-link {{ Request::is('surat/pengaturan/jenis-surat') ? 'active' : '' }}"
                            href="{{ url('surat/pengaturan/jenis-surat') }}">Jenis Surat</a>
                    </li>
                    <li class="nav-item"> <a
                            class="nav-link {{ Request::is('surat/pengaturan/sifat-surat') ? 'active' : '' }}"
                            href="{{ url('surat/pengaturan/sifat-surat') }}">Sifat Surat</a>
                    </li>
                    <li class="nav-item"> <a
                            class="nav-link {{ Request::is('surat/pengaturan/prioritas-surat') ? 'active' : '' }}"
                            href="{{ url('surat/pengaturan/prioritas-surat') }}">Prioritas
                            Surat</a></li>
                    <div class="dropdown-divider"></div>
                    <li class="nav-item"> <a
                            class="nav-link {{ Request::is('surat/pengaturan/folder-surat') ? 'active' : '' }}"
                            href="{{ url('surat/pengaturan/folder-surat') }}">Folder Arsip
                            Surat</a></li>
                    <div class="dropdown-divider"></div>
                    <li class="nav-item"> <a
                            class="nav-link {{ Request::is('surat/pengaturan/tipe-koreksi') ? 'active' : '' }}"
                            href="{{ url('surat/pengaturan/tipe-koreksi') }}">Tipe Koreksi
                            Surat</a></li>
                </ul>
            </div>
        </li>
        @endif
    </ul>
</nav>
