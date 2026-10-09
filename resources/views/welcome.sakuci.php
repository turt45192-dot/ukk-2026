@extends('layouts.app')

@section('title', config('app.name') . ' - Sistem Sarana & Prasarana')

@section('content')

    {{-- Hero Section dengan Dukungan Otomatis Light/Dark Mode --}}
    <section class="hero-section position-relative py-5 overflow-hidden text-center text-lg-start">
        {{-- Background Blur Ornamen Dekoratif Nuansa Biru --}}
        <div class="position-absolute top-0 start-50 translate-middle-x rounded-circle bg-primary opacity-10 filter-blur animate-pulse" style="width: 650px; height: 450px; z-index: 1;"></div>
        <div class="position-absolute bottom-0 end-0 rounded-circle bg-info opacity-10 filter-blur" style="width: 350px; height: 350px; z-index: 1;"></div>

        <div class="container py-lg-5 position-relative" style="z-index: 2;">
            <div class="row align-items-center g-5">
                {{-- Kolom Kiri: Teks & Aksi Utama --}}
                <div class="col-lg-7 text-center text-lg-start">
                    <div class="mb-3">
                        <span class="badge rounded-pill bg-primary-subtle text-primary px-4 py-2.5 fs-6 shadow-xs border border-primary border-opacity-50 d-inline-flex align-items-center gap-2">
                            <i class="bi bi-fire text-primary fs-5"></i> 
                            <span class="fw-bold tracking-wide">SAKUCI ONE FIRE
                        </span>
                    </div>

                    {{-- Logo Brand Utama --}}
                    <div class="mb-4 d-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 520 120" style="max-width: 320px; width: 100%; height: auto;">
                            <defs>
                                <linearGradient id="blueGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#0d6efd"/>
                                    <stop offset="100%" stop-color="#0a58ca"/>
                                </linearGradient>
                                <linearGradient id="accentGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#3d8bfd"/>
                                    <stop offset="100%" stop-color="#0242a0"/>
                                </linearGradient>
                                <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                                    <feDropShadow dx="0" dy="4" stdDeviation="6" flood-color="#0d6efd" flood-opacity="0.25"/>
                                </filter>
                            </defs>
                            <g filter="url(#glow)">
                                <rect x="10" y="10" width="100" height="100" rx="28" fill="url(#blueGradient)"/>
                                <path d="M35 82 V48 L60 30 L85 48 V82 Z" fill="none" stroke="#ffffff" stroke-width="6" stroke-linejoin="round"/>
                                <rect x="48" y="55" width="24" height="27" rx="4" fill="url(#accentGradient)" stroke="#ffffff" stroke-width="2"/>
                                <circle cx="60" cy="42" r="4" fill="#ffffff"/>
                            </g>
                            <text x="130" y="62" font-family="'Plus Jakarta Sans', 'Segoe UI', sans-serif" font-weight="900" font-size="40" fill="#0d6efd" letter-spacing="2">
                                SARPRAS
                            </text>
                            <text x="130" y="96" font-family="'Plus Jakarta Sans', 'Segoe UI', sans-serif" font-weight="800" font-size="28" fill="#1e293b" letter-spacing="4">
                                SAKUCI
                            </text>
                            <text x="325" y="62" font-family="'Plus Jakarta Sans', 'Segoe UI', sans-serif" font-weight="600" font-size="12" fill="#64748b" letter-spacing="1">
                                
                            </text>
                            
                        </svg>
                    </div>

                    <h1 class="display-5 fw-black mb-4 tracking-tight lh-tight text-body" style="font-weight: 800;">
                        Pusat Kendali & Layanan <br class="d-none d-md-inline">
                        <span class="text-gradient-blue text-uppercase fw-extrabold">SARPRAS SAKUCI</span>
                    </h1>

                    <p class="lead text-body-secondary mb-5 mx-auto mx-lg-0" style="max-width: 600px; font-weight: 500; line-height: 1.7;">
                        Sistem informasi digital modern SMK Sangkuriang 1 Cimahi untuk manajemen inventaris alat, pemetaan prasarana, serta transparansi fasilitas sekolah secara real-time.
                    </p>

                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start align-items-center mb-4">
                        <a class="btn btn-primary btn-lg px-4.5 py-3.5 rounded-pill shadow-lg fw-bold d-inline-flex align-items-center gap-2 hover-scale text-white" href="#ringkasan" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); border: none;">
                            <i class="bi bi-speedometer2 fs-5"></i>
                            <span>Jelajahi Dashboard</span>
                        </a>
                        <a class="btn btn-outline-secondary btn-lg px-4.5 py-3.5 rounded-pill fw-bold d-inline-flex align-items-center gap-2 hover-scale" href="#panduan">
                            <i class="bi bi-journal-bookmark-fill fs-5 text-primary"></i>
                            <span>Panduan Sistem</span>
                        </a>
                    </div>
                </div>

                {{-- Kolom Kanan: Quick Stats Showcase Card --}}
                <div class="col-lg-5">
                    <div class="card border-0 shadow-lg rounded-5 bg-body p-4 position-relative overflow-hidden hover-lift border-top border-primary border-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h5 class="fw-bold m-0 text-body"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Status Inventaris</h5>
                                <span class="badge bg-primary-subtle text-primary px-3 py-1.5 rounded-pill fw-bold shadow-xs">
                                    <span class="spinner-grow spinner-grow-sm text-primary me-1" role="status" style="width: 8px; height: 8px;"></span> Live System
                                </span>
                            </div>

                            <div class="d-flex flex-column gap-3">
                                {{-- Stat Item 1 --}}
                                <div class="d-flex align-items-center justify-content-between p-3 bg-body-tertiary rounded-4 border border-opacity-10 hover-bg-subtle transition-all">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 bg-primary bg-opacity-15 text-primary p-2 d-flex align-items-center justify-content-center shadow-xs" style="width: 44px; height: 44px;">
                                            <i class="bi bi-tags-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-body">Total Kategori</h6>
                                            <small class="text-body-secondary">Pengelompokan Barang</small>
                                        </div>
                                    </div>
                                    <h3 class="fw-black text-primary mb-0">{{ $totalKategori ?? 0 }}</h3>
                                </div>

                                {{-- Stat Item 2 --}}
                                <div class="d-flex align-items-center justify-content-between p-3 bg-body-tertiary rounded-4 border border-opacity-10 hover-bg-subtle transition-all">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 bg-primary bg-opacity-25 text-primary p-2 d-flex align-items-center justify-content-center shadow-xs" style="width: 44px; height: 44px;">
                                            <i class="bi bi-tools fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-body">Inventaris Alat</h6>
                                            <small class="text-body-secondary">Fasilitas & Barang</small>
                                        </div>
                                    </div>
                                    <h3 class="fw-black text-primary mb-0">{{ $totalAlat ?? 0 }}</h3>
                                </div>

                                {{-- Stat Item 3 --}}
                                <div class="d-flex align-items-center justify-content-between p-3 bg-body-tertiary rounded-4 border border-opacity-10 hover-bg-subtle transition-all">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 bg-success bg-opacity-15 text-success p-2 d-flex align-items-center justify-content-center shadow-xs" style="width: 44px; height: 44px;">
                                            <i class="bi bi-people-fill fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0 text-body">Pengguna Aktif</h6>
                                            <small class="text-body-secondary">Admin, Guru & Siswa</small>
                                        </div>
                                    </div>
                                    <h3 class="fw-black text-success mb-0">{{ $totalPengguna ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Cards & Dynamic Relational Data --}}
    <section id="ringkasan" class="py-5 bg-body-tertiary border-top border-bottom">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="badge bg-primary-subtle text-primary px-3.5 py-2 rounded-pill fw-bold mb-2 text-uppercase tracking-wider shadow-xs" style="font-size: 0.75rem;">Dashboard Interaktif</span>
                <h2 class="fw-bold text-body"><i class="bi bi-speedometer2 text-primary me-2"></i>Ringkasan Data Terintegrasi</h2>
                <p class="text-body-secondary fw-medium">Keterhubungan real-time antara Kategori, Inventaris Alat, dan Hak Akses Pengguna</p>
            </div>

            <div class="row g-4 mb-5">
                {{-- Card Kategori --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 hover-lift h-100 bg-body border border-opacity-10 position-relative overflow-hidden border-top border-primary border-4">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="rounded-4 bg-primary bg-opacity-15 text-primary d-inline-flex align-items-center justify-content-center shadow-xs" style="width: 54px; height: 54px;">
                                    <i class="bi bi-tags-fill fs-4"></i>
                                </div>
                                <span class="badge bg-primary text-white fw-bold px-3.5 py-2 rounded-pill fs-5">{{ $totalKategori ?? 0 }}</span>
                            </div>
                            
                            <h5 class="fw-bold text-body mb-1">Kategori Terdaftar</h5>
                            <p class="text-body-secondary small mb-3">Pengelompokan jenis sarana & prasarana sekolah.</p>

                            <hr class="my-2 opacity-25">

                            <div class="flex-grow-1 mb-3">
                                <span class="d-block text-uppercase text-body-secondary fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">Daftar Kategori Utama</span>
                                <div class="d-flex flex-wrap gap-1.5">
                                    @forelse($kategoriList ?? [] as $kat)
                                        <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-50 fw-semibold rounded-pill py-1.5 px-3">
                                            {{ $kat->nama_kategori }} <span class="badge bg-primary text-white ms-1 rounded-circle" style="font-size: 0.6rem;">{{ $kat->alat_count ?? $kat->alat->count() ?? 0 }}</span>
                                        </span>
                                    @empty
                                        <small class="text-muted fst-italic">Belum ada kategori terdaftar.</small>
                                    @endforelse
                                </div>
                            </div>

                            <a href="{{ route('kategori.index') }}" class="btn btn-light-primary w-100 rounded-pill fw-bold py-2.5 mt-auto d-flex align-items-center justify-content-center gap-2">
                                <span>Kelola Kategori</span> <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Card Alat --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 hover-lift h-100 bg-body border border-opacity-10 position-relative overflow-hidden border-top border-primary border-4">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="rounded-4 bg-primary bg-opacity-15 text-primary d-inline-flex align-items-center justify-content-center shadow-xs" style="width: 54px; height: 54px;">
                                    <i class="bi bi-tools fs-4"></i>
                                </div>
                                <span class="badge bg-primary text-white fw-bold px-3.5 py-2 rounded-pill fs-5">{{ $totalAlat ?? 0 }}</span>
                            </div>

                            <h5 class="fw-bold text-body mb-1">Total Alat & Barang</h5>
                            <p class="text-body-secondary small mb-3">Inventaris alat praktikum & fasilitas sekolah.</p>

                            <hr class="my-2 opacity-25">

                            <div class="flex-grow-1 mb-3">
                                <span class="d-block text-uppercase text-body-secondary fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">Contoh Alat Terhubung</span>
                                <ul class="list-unstyled small text-body-secondary mb-0 d-flex flex-column gap-2">
                                    @forelse($alatList ?? [] as $item)
                                        <li class="d-flex align-items-center justify-content-between bg-body-tertiary px-3 py-2 rounded-3 border border-1 border-primary border-opacity-25">
                                            <span class="text-truncate fw-bold text-body" style="max-width: 150px;">
                                                <i class="bi bi-box-seam me-1.5 text-primary"></i>{{ $item->nama_alat }}
                                            </span>
                                            <span class="badge bg-primary text-white small px-2.5 py-1 rounded-pill">
                                                {{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                            </span>
                                        </li>
                                    @empty
                                        <li class="text-muted small fst-italic">Belum ada data alat terdaftar.</li>
                                    @endforelse
                                </ul>
                            </div>

                            <a href="{{ route('alat.index') }}" class="btn btn-light-primary w-100 rounded-pill fw-bold py-2.5 mt-auto d-flex align-items-center justify-content-center gap-2">
                                <span>Kelola Alat</span> <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Card Pengguna --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 hover-lift h-100 bg-body border border-opacity-10 position-relative overflow-hidden border-top border-success border-4">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="rounded-4 bg-success bg-opacity-15 text-success d-inline-flex align-items-center justify-content-center shadow-xs" style="width: 54px; height: 54px;">
                                    <i class="bi bi-people-fill fs-4"></i>
                                </div>
                                <span class="badge bg-success text-white fw-bold px-3.5 py-2 rounded-pill fs-5">{{ $totalPengguna ?? 0 }}</span>
                            </div>

                            <h5 class="fw-bold text-body mb-1">Pengguna Terdaftar</h5>
                            <p class="text-body-secondary small mb-3">Administrator, guru, dan siswa yang aktif.</p>

                            <hr class="my-2 opacity-25">

                            <div class="flex-grow-1 mb-3">
                                <span class="d-block text-uppercase text-body-secondary fw-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">Pengguna Aktif Terbaru</span>
                                <ul class="list-unstyled small text-body-secondary mb-0 d-flex flex-column gap-2">
                                    @forelse($penggunaList ?? [] as $user)
                                        <li class="d-flex align-items-center justify-content-between bg-body-tertiary px-3 py-2 rounded-3 border border-1 border-success border-opacity-25">
                                            <span class="text-truncate fw-bold text-body" style="max-width: 150px;">
                                                <i class="bi bi-person-circle me-1.5 text-success"></i>{{ $user->name ?? $user->nama }}
                                            </span>
                                            <span class="badge bg-success text-white text-uppercase px-2.5 py-1 rounded-pill fw-bold" style="font-size: 0.65rem;">
                                                {{ $user->role ?? 'User' }}
                                            </span>
                                        </li>
                                    @empty
                                        <li class="text-muted small fst-italic">Belum ada pengguna terdaftar.</li>
                                    @endforelse
                                </ul>
                            </div>

                            <a href="{{ route('pengguna.index') }}" class="btn btn-light-success w-100 rounded-pill fw-bold py-2.5 mt-auto d-flex align-items-center justify-content-center gap-2">
                                <span>Kelola Pengguna</span> <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Keunggulan Sistem Section --}}
    <section class="py-5 bg-body my-4">
        <div class="container py-3">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <span class="text-primary fw-bold text-uppercase tracking-wider small">Keunggulan SAKUCI</span>
                    <h2 class="fw-bold text-body mb-3 mt-1">Mengapa Menggunakan Sistem Sarpras Ini?</h2>
                    <p class="text-body-secondary fw-medium mb-4">
                        Dibangun khusus untuk memenuhi standar digitalisasi sekolah modern di SMK Sangkuriang 1 Cimahi, mengoptimalkan transparansi dan kecepatan pelayanan inventaris.
                    </p>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-circle bg-primary text-white p-2 mt-1 shadow-sm">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-body mb-1">Real-time Tracking</h6>
                                <p class="text-body-secondary small mb-0">Pantau peminjaman dan ketersediaan alat langsung dari perangkat apa saja.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-circle bg-primary text-white p-2 mt-1 shadow-sm">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-body mb-1">Terstruktur & Relasional</h6>
                                <p class="text-body-secondary small mb-0">Pengelompokan barang berbasis kategori dan manajemen hak akses pengguna yang ketat.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="card border-0 shadow-sm p-4 rounded-4 bg-body border border-opacity-10 h-100 hover-lift border-start border-primary border-4">
                                <i class="bi bi-shield-lock-fill text-primary fs-2 mb-3"></i>
                                <h5 class="fw-bold text-body mb-2">Aman & Terkontrol</h5>
                                <p class="text-body-secondary small mb-0">Sistem login berlapis sesuai role (Admin, Guru, Siswa).</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card border-0 shadow-sm p-4 rounded-4 bg-body border border-opacity-10 h-100 hover-lift border-start border-primary border-4">
                                <i class="bi bi-phone-fill text-primary fs-2 mb-3"></i>
                                <h5 class="fw-bold text-body mb-2">Responsive Design</h5>
                                <p class="text-body-secondary small mb-0">Nyaman diakses melalui komputer, tablet, maupun smartphone.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Panduan Penggunaan --}}
    <section id="panduan" class="py-5 bg-body border-top">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="text-primary fw-bold text-uppercase tracking-wider small">Panduan Singkat</span>
                <h2 class="fw-bold text-body">Langkah Penggunaan Aplikasi</h2>
                <p class="text-body-secondary fw-medium">Alur kerja terintegrasi antara Kategori, Alat, dan Pengguna</p>
            </div>

            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card border-0 bg-body shadow-sm h-100 text-center p-4 rounded-4 border border-opacity-10 hover-lift">
                        <div class="step-number bg-primary text-white fw-bold rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">1</div>
                        <h6 class="fw-bold text-body mb-2">Login Pengguna</h6>
                        <p class="text-body-secondary small m-0">Pengguna masuk ke akun yang sudah terdaftar di sistem dengan hak akses masing-masing.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 bg-body shadow-sm h-100 text-center p-4 rounded-4 border border-opacity-10 hover-lift">
                        <div class="step-number bg-primary text-white fw-bold rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">2</div>
                        <h6 class="fw-bold text-body mb-2">Kelola Kategori</h6>
                        <p class="text-body-secondary small m-0">Admin membuat pengelompokan kategori barang untuk mempermudah pemetaan inventaris.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 bg-body shadow-sm h-100 text-center p-4 rounded-4 border border-opacity-10 hover-lift">
                        <div class="step-number bg-primary text-white fw-bold rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">3</div>
                        <h6 class="fw-bold text-body mb-2">Hubungkan Alat</h6>
                        <p class="text-body-secondary small m-0">Input data alat dan pilih kategori yang sesuai secara otomatis terhubung ke sistem.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 bg-body shadow-sm h-100 text-center p-4 rounded-4 border border-opacity-10 hover-lift">
                        <div class="step-number bg-primary text-white fw-bold rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">4</div>
                        <h6 class="fw-bold text-body mb-2">Pantau Inventaris</h6>
                        <p class="text-body-secondary small m-0">Seluruh warga sekolah dapat memantau ketersediaan barang sesuai hak aksesnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Style Tambahan --}}
    <style>
        :root {
            color-scheme: light dark;
        }
        .filter-blur {
            filter: blur(60px);
        }
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 32px rgba(13, 110, 253, 0.15) !important;
        }
        .hover-scale {
            transition: transform 0.2s ease;
        }
        .hover-scale:hover {
            transform: scale(1.03);
        }
        .text-gradient-blue {
            background: linear-gradient(135deg, #0d6efd 0%, #034ea2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Tombol Khusus */
        .btn-light-primary {
            background-color: rgba(13, 110, 253, 0.12);
            color: var(--bs-body-color);
            border: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-light-primary:hover {
            background-color: #0d6efd;
            color: #fff;
        }
        .btn-light-success {
            background-color: rgba(25, 135, 84, 0.12);
            color: var(--bs-body-color);
            border: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-light-success:hover {
            background-color: #198754;
            color: #fff;
        }
        .shadow-xs {
            box-shadow: 0 2px 8px rgba(0,0,0,0.04) !important;
        }
        .hover-bg-subtle:hover {
            background-color: rgba(13, 110, 253, 0.05) !important;
        }
        .transition-all {
            transition: all 0.2s ease-in-out;
        }
    </style>

@endsection