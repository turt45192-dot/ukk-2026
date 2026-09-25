@extends('layouts.app')

@section('title', config('app.name') . ' - Sistem Sarana & Prasarana')

@section('content')

    {{-- Hero Section --}}
    <section class="text-center py-4 py-lg-5">
        <span class="badge rounded-pill badge-brand px-3 py-2 mb-3">SAKUCI WELL</span>

        <h1 class="display-5 fw-bold mb-3">
            Aplikasi Sarana & Prasarana<br class="d-none d-md-inline">
            <span class="text-brand">SMK SANGKURIANG 1 CIMAHI</span>
        </h1>

        <p class="lead text-secondary mx-auto mb-4" style="max-width: 620px;">
            Sistem pengelolaan sarana, prasarana, alat, dan kategori barang untuk mendukung operasional sekolah menuju Indonesia Emas.
        </p>

        <div class="d-flex flex-wrap gap-2 justify-content-center mb-4">
            <a class="btn btn-brand btn-lg px-4" href="#ringkasan">Lihat Ringkasan</a>
            <a class="btn btn-outline-brand btn-lg px-4" href="https://github.com/indrabsus/sakuci-framework" target="_blank">GitHub</a>
        </div>

        <p class="text-secondary small mt-3 mb-0">
            Panduan langkah demi langkah ada di berkas
            <code class="inline">TUTORIAL.md</code>
        </p>
    </section>

    {{-- Stats Cards (Pengguna, Alat, Kategori) --}}
    <section id="ringkasan" class="py-4">
        <div class="row g-4">
            
            {{-- Card Kategori --}}
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4 text-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-tags fs-3"></i>
                        </div>
                        <h2 class="fw-bold mb-1">{{ $totalKategori ?? 0 }}</h2>
                        <h5 class="card-title text-secondary mb-3">Kategori</h5>
                        <p class="card-text text-muted small">
                            Kelompokkan alat dan fasilitas sekolah berdasarkan jenisnya.
                        </p>
                        <a href="{{ route('kategori.index') }}" class="btn btn-outline-primary btn-sm w-100 mt-2">Kelola Kategori</a>
                    </div>
                </div>
            </div>

            {{-- Card Alat --}}
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4 text-center">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-tools fs-3"></i>
                        </div>
                        <h2 class="fw-bold mb-1">{{ $totalAlat ?? 0 }}</h2>
                        <h5 class="card-title text-secondary mb-3">Alat & Barang</h5>
                        <p class="card-text text-muted small">
                            Daftar inventaris sarana dan prasarana yang tersedia di sekolah.
                        </p>
                        <a href="{{ route('alat.index') }}" class="btn btn-outline-success btn-sm w-100 mt-2">Kelola Alat</a>
                    </div>
                </div>
            </div>

            {{-- Card Pengguna --}}
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4 text-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-people fs-3"></i>
                        </div>
                        <h2 class="fw-bold mb-1">{{ $totalPengguna ?? 0 }}</h2>
                        <h5 class="card-title text-secondary mb-3">Pengguna</h5>
                        <p class="card-text text-muted small">
                            Admin, staf, dan siswa yang terdaftar dalam sistem inventaris.
                        </p>
                        <a href="{{ route('pengguna.index') }}" class="btn btn-outline-warning btn-sm w-100 mt-2">Kelola Pengguna</a>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection