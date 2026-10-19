@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
@php
    // Isi ulang input jika helper old() tersedia di framework
    $oldVal = function ($key) {
        return function_exists('old') ? old($key) : '';
    };
@endphp

<div class="container-fluid px-0 py-3">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8 col-xxl-6">

            {{-- ===== Header ===== --}}
            <div class="mb-4 text-center text-sm-start">
                <a href="{{ route('pengguna.index') }}" class="pg-back text-decoration-none d-inline-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-arrow-left"></i> Kembali ke daftar pengguna
                </a>
                <h1 class="pg-title mb-1">
                    <i class="bi bi-person-plus-fill text-primary me-2"></i>Tambah Pengguna
                </h1>
                <p class="text-body-secondary mb-0">Isi data di bawah ini untuk mendaftarkan pengguna baru.</p>
            </div>

            {{-- ===== Notifikasi ===== --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            {{-- ===== Kartu Form ===== --}}
            <div class="pg-card">
                <div class="pg-card-head">
                    <div class="pg-avatar"><i class="bi bi-person-fill"></i></div>
                    <div class="min-w-0">
                        <h2 class="h6 fw-bold mb-0">Data Pengguna</h2>
                        <small class="text-body-secondary">Semua kolom wajib diisi</small>
                    </div>
                </div>

                <form action="{{ route('pengguna.store') }}" method="POST" id="penggunaForm" class="pg-body">
                    @csrf

                    <div class="row g-4">
                        {{-- Nama --}}
                        <div class="col-12">
                            <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                            <div class="input-group pg-input">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" id="nama" name="nama" class="form-control"
                                       placeholder="Contoh: Budi Santoso" value="{{ $oldVal('nama') }}"
                                       autocomplete="name" required>
                            </div>
                        </div>

                        {{-- NIS --}}
                        <div class="col-12 col-md-6">
                            <label for="nis" class="form-label fw-semibold">NIS</label>
                            <div class="input-group pg-input">
                                <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                <input type="text" id="nis" name="nis" class="form-control"
                                       placeholder="Nomor Induk Siswa" value="{{ $oldVal('nis') }}"
                                       inputmode="numeric" autocomplete="off" required>
                            </div>
                        </div>

                        {{-- Kelas --}}
                        <div class="col-12 col-md-6">
                            <label for="kelas" class="form-label fw-semibold">Kelas</label>
                            <div class="input-group pg-input">
                                <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                                <input type="text" id="kelas" name="kelas" class="form-control"
                                       placeholder="Contoh: XII RPL 1" value="{{ $oldVal('kelas') }}"
                                       autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    {{-- Aksi --}}
                    <div class="pg-actions">
                        <a href="{{ route('pengguna.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
                            Batal
                        </a>
                        <button type="submit" id="pgSubmit" class="btn pg-btn-primary rounded-pill px-4 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                            <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                            <i class="bi bi-check2-circle pg-submit-icon"></i>
                            <span class="pg-submit-text">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .min-w-0 { min-width: 0; }
    .pg-title { font-size: clamp(1.4rem, 1.1rem + 1.4vw, 2rem); font-weight: 800; letter-spacing: -.01em; }
    .pg-back { font-size: .9rem; font-weight: 600; color: var(--bs-secondary-color); transition: color .2s, transform .2s; }
    .pg-back:hover { color: var(--bs-primary); transform: translateX(-3px); }

    .pg-card {
        border-radius: 1.5rem; overflow: hidden; background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color); border-top: 4px solid var(--bs-primary);
        box-shadow: 0 16px 40px rgba(13,110,253,.1);
    }
    .pg-card-head {
        display: flex; align-items: center; gap: .85rem;
        padding: 1.1rem clamp(1rem, 3vw, 1.75rem);
        background: var(--bs-tertiary-bg); border-bottom: 1px solid var(--bs-border-color);
    }
    .pg-avatar {
        width: 46px; height: 46px; flex-shrink: 0; border-radius: 1rem;
        display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #fff;
        background: linear-gradient(135deg, #3d8bfd, #0a58ca); box-shadow: 0 8px 18px rgba(13,110,253,.3);
    }
    .pg-body { padding: clamp(1.1rem, 3.5vw, 2rem); }

    /* Input */
    .pg-input .input-group-text { color: var(--bs-primary); background: var(--bs-tertiary-bg); border-radius: .85rem 0 0 .85rem; padding-inline: 1rem; }
    .pg-input .form-control { padding-block: .75rem; border-radius: 0 .85rem .85rem 0; }
    .pg-input:focus-within .input-group-text,
    .pg-input:focus-within .form-control { border-color: var(--bs-primary); }
    .pg-input:focus-within { border-radius: .85rem; box-shadow: 0 0 0 .25rem rgba(13,110,253,.15); }
    .pg-input .form-control:focus { box-shadow: none; }

    /* Tombol */
    .pg-actions { display: flex; flex-direction: column-reverse; gap: .75rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px dashed var(--bs-border-color); }
    .pg-actions .btn { padding-block: .7rem; }
    @media (min-width: 576px) {
        .pg-actions { flex-direction: row; justify-content: flex-end; }
    }
    .pg-btn-primary {
        color: #fff; border: 0; background: linear-gradient(135deg, #0d6efd, #0a58ca);
        box-shadow: 0 10px 22px rgba(13,110,253,.35); transition: transform .2s, box-shadow .2s;
    }
    .pg-btn-primary:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 14px 28px rgba(13,110,253,.45); }
    .pg-btn-primary:disabled { opacity: .85; transform: none; }

    @media (prefers-reduced-motion: reduce) {
        .pg-back, .pg-btn-primary { transition: none; }
        .pg-back:hover, .pg-btn-primary:hover { transform: none; }
    }
</style>

<script>
    // Cegah klik ganda saat menyimpan & tampilkan indikator loading
    (function () {
        var form = document.getElementById('penggunaForm');
        var btn = document.getElementById('pgSubmit');
        if (!form || !btn) return;

        form.addEventListener('submit', function () {
            if (!form.checkValidity()) return;
            btn.disabled = true;
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.querySelector('.pg-submit-icon').classList.add('d-none');
            btn.querySelector('.pg-submit-text').textContent = 'Menyimpan...';
        });

        // Tombol "Kembali" browser: kembalikan tombol ke keadaan semula
        window.addEventListener('pageshow', function (e) {
            if (!e.persisted) return;
            btn.disabled = false;
            btn.querySelector('.spinner-border').classList.add('d-none');
            btn.querySelector('.pg-submit-icon').classList.remove('d-none');
            btn.querySelector('.pg-submit-text').textContent = 'Simpan';
        });
    })();
</script>
@endsection