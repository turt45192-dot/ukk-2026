@extends('layouts.app')

@section('title', config('app.name') . ' - Sistem Sarana & Prasarana')

@section('content')

    {{-- Hero Section --}}
    <section class="position-relative py-5 overflow-hidden text-center">
        <div class="position-absolute top-0 start-0 translate-middle rounded-circle bg-primary opacity-10 filter-blur" style="width: 300px; height: 300px; z-index: -1;"></div>
        <div class="position-absolute bottom-0 end-0 translate-middle-x rounded-circle bg-warning opacity-10 filter-blur" style="width: 250px; height: 250px; z-index: -1;"></div>

        <div class="container py-lg-4">
            <span class="badge rounded-pill bg-brand-subtle text-brand px-3 py-2 fs-6 mb-3 shadow-sm border border-brand border-opacity-25 d-inline-flex align-items-center gap-2">
                <i class="bi bi-fire text-danger"></i> SAKUCI ONE FIRE
            </span>

            <h1 class="display-4 fw-black mb-3 text-body tracking-tight">
                Aplikasi Sarana & Prasarana<br class="d-none d-md-inline">
                <span class="text-gradient-brand">SMK SANGKURIANG 1 CIMAHI</span>
            </h1>

            <p class="lead text-body-secondary mx-auto mb-4" style="max-width: 680px; font-weight: 400; line-height: 1.6;">
                Sistem terpadu pengelolaan sarana, prasarana, inventarisir alat, dan pengajuan aspirasi sekolah secara digital dan transparan.
            </p>

            <div class="d-flex flex-wrap gap-3 justify-content-center align-items-center mb-4">
                <a class="btn btn-brand btn-lg px-4 py-2.5 rounded-3 shadow-sm fw-semibold d-inline-flex align-items-center gap-2 hover-scale" href="#ringkasan">
                    <i class="bi bi-grid-fill"></i>
                    <span>Mulai Jelajahi</span>
                </a>
                <a class="btn btn-outline-secondary btn-lg px-4 py-2.5 rounded-3 fw-semibold d-inline-flex align-items-center gap-2 hover-scale" href="#panduan">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span>Panduan Penggunaan</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Stats Cards & Dynamic Relational Data --}}
    <section id="ringkasan" class="py-4">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-bold m-0"><i class="bi bi-speedometer2 text-brand me-2"></i>Ringkasan Data Terintegrasi</h3>
                    <small class="text-body-secondary">Keterhubungan antara Kategori, Inventaris Alat, dan Pengguna Terdaftar</small>
                </div>
            </div>

            <div class="row g-4 mb-5">
                {{-- Card Kategori --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 hover-lift h-100 bg-body">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="text-center mb-3">
                                <div class="rounded-4 bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width: 60px; height: 60px;">
                                    <i class="bi bi-tags-fill fs-2"></i>
                                </div>
                                <h2 class="display-6 fw-bold text-body mb-0">{{ $totalKategori ?? 0 }}</h2>
                                <h6 class="fw-semibold text-body-secondary">Kategori Terdaftar</h6>
                            </div>
                            
                            <hr class="my-3 opacity-10">

                            {{-- Relasi Kategori Ke Jumlah Alat --}}
                            <div class="flex-grow-1 mb-3">
                                <span class="d-block text-uppercase text-body-secondary fw-bold mb-2" style="font-size: 0.72rem; letter-spacing: 0.5px;">Daftar Kategori Utama</span>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse($kategoriList ?? [] as $kat)
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">
                                            {{ $kat->nama_kategori }} ({{ $kat->alat_count ?? $kat->alat->count() ?? 0 }})
                                        </span>
                                    @empty
                                        <small class="text-muted">Belum ada kategori terdaftar.</small>
                                    @endforelse
                                </div>
                            </div>

                            <a href="{{ route('kategori.index') }}" class="btn btn-light-primary w-100 rounded-3 fw-semibold py-2 mt-auto">
                                Kelola Kategori <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Card Alat & Relasi Kategori --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 hover-lift h-100 bg-body">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="text-center mb-3">
                                <div class="rounded-4 bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width: 60px; height: 60px;">
                                    <i class="bi bi-tools fs-2"></i>
                                </div>
                                <h2 class="display-6 fw-bold text-body mb-0">{{ $totalAlat ?? 0 }}</h2>
                                <h6 class="fw-semibold text-body-secondary">Total Alat & Barang</h6>
                            </div>

                            <hr class="my-3 opacity-10">

                            {{-- Relasi Alat Ke Kategori --}}
                            <div class="flex-grow-1 mb-3">
                                <span class="d-block text-uppercase text-body-secondary fw-bold mb-2" style="font-size: 0.72rem; letter-spacing: 0.5px;">Contoh Alat Terhubung</span>
                                <ul class="list-unstyled small text-body-secondary mb-0 d-flex flex-column gap-2">
                                    @forelse($alatList ?? [] as $item)
                                        <li class="d-flex align-items-center justify-content-between">
                                            <span class="text-truncate" style="max-width: 140px;">
                                                <i class="bi bi-box-seam me-1 text-success"></i>{{ $item->nama_alat }}
                                            </span>
                                            <span class="badge bg-secondary-subtle text-secondary small">
                                                {{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                            </span>
                                        </li>
                                    @empty
                                        <li class="text-muted small">Belum ada data alat terdaftar.</li>
                                    @endforelse
                                </ul>
                            </div>

                            <a href="{{ route('alat.index') }}" class="btn btn-light-success w-100 rounded-3 fw-semibold py-2 mt-auto">
                                Kelola Alat <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Card Pengguna & Relasi Hak Akses --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 hover-lift h-100 bg-body">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="text-center mb-3">
                                <div class="rounded-4 bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center mx-auto mb-2" style="width: 60px; height: 60px;">
                                    <i class="bi bi-people-fill fs-2"></i>
                                </div>
                                <h2 class="display-6 fw-bold text-body mb-0">{{ $totalPengguna ?? 0 }}</h2>
                                <h6 class="fw-semibold text-body-secondary">Pengguna Terdaftar</h6>
                            </div>

                            <hr class="my-3 opacity-10">

                            {{-- Relasi Pengguna Ke Peran/Role --}}
                            <div class="flex-grow-1 mb-3">
                                <span class="d-block text-uppercase text-body-secondary fw-bold mb-2" style="font-size: 0.72rem; letter-spacing: 0.5px;">Pengguna Aktif Terbaru</span>
                                <ul class="list-unstyled small text-body-secondary mb-0 d-flex flex-column gap-2">
                                    @forelse($penggunaList ?? [] as $user)
                                        <li class="d-flex align-items-center justify-content-between">
                                            <span class="text-truncate" style="max-width: 140px;">
                                                <i class="bi bi-person-circle me-1 text-warning"></i>{{ $user->name ?? $user->nama }}
                                            </span>
                                            <span class="badge bg-warning-subtle text-warning-emphasis text-uppercase" style="font-size: 0.65rem;">
                                                {{ $user->role ?? 'User' }}
                                            </span>
                                        </li>
                                    @empty
                                        <li class="text-muted small">Belum ada pengguna terdaftar.</li>
                                    @endforelse
                                </ul>
                            </div>

                            <a href="{{ route('pengguna.index') }}" class="btn btn-light-warning w-100 rounded-3 fw-semibold py-2 mt-auto">
                                Kelola Pengguna <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Panduan Penggunaan --}}
    <section id="panduan" class="py-5 bg-body-tertiary rounded-4 my-4">
        <div class="container">
            <div class="text-center mb-5">
                <span class="text-brand fw-bold text-uppercase tracking-wider small">Panduan Singkat</span>
                <h2 class="fw-bold">Langkah Penggunaan Aplikasi</h2>
                <p class="text-body-secondary">Alur kerja terintegrasi antara Kategori, Alat, dan Pengguna</p>
            </div>

            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card border-0 bg-body shadow-sm h-100 text-center p-3 rounded-4">
                        <div class="step-number bg-brand text-white fw-bold rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">1</div>
                        <h6 class="fw-bold">Login Pengguna</h6>
                        <p class="text-body-secondary small m-0">Pengguna (Admin/Siswa) masuk ke akun yang sudah terdaftar di sistem.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 bg-body shadow-sm h-100 text-center p-3 rounded-4">
                        <div class="step-number bg-brand text-white fw-bold rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">2</div>
                        <h6 class="fw-bold">Kelola Kategori</h6>
                        <p class="text-body-secondary small m-0">Admin membuat pengelompokan kategori barang untuk mempermudah pemetaan.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 bg-body shadow-sm h-100 text-center p-3 rounded-4">
                        <div class="step-number bg-brand text-white fw-bold rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">3</div>
                        <h6 class="fw-bold">Hubungkan Alat</h6>
                        <p class="text-body-secondary small m-0">Input data alat dan pilih kategori yang sesuai secara otomatis.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 bg-body shadow-sm h-100 text-center p-3 rounded-4">
                        <div class="step-number bg-brand text-white fw-bold rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">4</div>
                        <h6 class="fw-bold">Pantau Inventaris</h6>
                        <p class="text-body-secondary small m-0">Seluruh pengguna dapat memantau ketersediaan barang sesuai hak aksesnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Style Tambahan --}}
    <style>
        .filter-blur {
            filter: blur(50px);
        }
        .hover-lift {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
        }
        .hover-scale {
            transition: transform 0.2s ease;
        }
        .hover-scale:hover {
            transform: scale(1.03);
        }
        .text-gradient-brand {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-light-primary {
            background-color: rgba(13, 110, 253, 0.08);
            color: #0d6efd;
            border: none;
        }
        .btn-light-primary:hover {
            background-color: #0d6efd;
            color: #fff;
        }
        .btn-light-success {
            background-color: rgba(25, 135, 84, 0.08);
            color: #198754;
            border: none;
        }
        .btn-light-success:hover {
            background-color: #198754;
            color: #fff;
        }
        .btn-light-warning {
            background-color: rgba(255, 193, 7, 0.12);
            color: #b58100;
            border: none;
        }
        .btn-light-warning:hover {
            background-color: #ffc107;
            color: #000;
        }
    </style>

@endsection