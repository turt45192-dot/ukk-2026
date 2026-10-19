@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
@php
    // Isi ulang input jika helper old() tersedia di framework
    $oldNama = function_exists('old') ? old('nama_kategori') : '';
@endphp

<div class="container-fluid px-0 py-3">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9 col-xl-7 col-xxl-5">

            {{-- ===== Header ===== --}}
            <div class="mb-4 text-center text-sm-start">
                <a href="{{ route('kategori.index') }}" class="kt-back text-decoration-none d-inline-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-arrow-left"></i> Kembali ke daftar kategori
                </a>
                <h1 class="kt-title mb-1">
                    <i class="bi bi-grid-fill text-primary me-2"></i>Tambah Kategori
                </h1>
                <p class="text-body-secondary mb-0">Buat kategori baru untuk mengelompokkan alat dan aspirasi.</p>
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
            <div class="kt-card">
                <div class="kt-card-head">
                    <div class="kt-icon"><i class="bi bi-tags-fill"></i></div>
                    <div class="min-w-0">
                        <h2 class="h6 fw-bold mb-0">Data Kategori</h2>
                        <small class="text-body-secondary">Kolom wajib diisi</small>
                    </div>
                </div>

                <form action="{{ route('kategori.store') }}" method="POST" id="kategoriForm" class="kt-body">
                    @csrf

                    <label for="nama_kategori" class="form-label fw-semibold">Nama Kategori</label>
                    <div class="input-group kt-input">
                        <span class="input-group-text"><i class="bi bi-tag"></i></span>
                        <input type="text" id="nama_kategori" name="nama_kategori" class="form-control"
                               placeholder="Contoh: Elektronik, Furniture, Olahraga"
                               value="{{ $oldNama }}" maxlength="100" autocomplete="off" required autofocus>
                    </div>
                    <div class="d-flex justify-content-between gap-2 mt-2">
                        <small class="text-body-secondary">Gunakan nama yang singkat dan jelas.</small>
                        <small class="text-body-secondary text-nowrap"><span id="ktCount">0</span>/100</small>
                    </div>

                    {{-- Aksi --}}
                    <div class="kt-actions">
                        <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
                            Batal
                        </a>
                        <button type="submit" id="ktSubmit" class="btn kt-btn-primary rounded-pill px-4 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                            <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                            <i class="bi bi-check2-circle kt-submit-icon"></i>
                            <span class="kt-submit-text">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .min-w-0 { min-width: 0; }
    .kt-title { font-size: clamp(1.4rem, 1.1rem + 1.4vw, 2rem); font-weight: 800; letter-spacing: -.01em; }
    .kt-back { font-size: .9rem; font-weight: 600; color: var(--bs-secondary-color); transition: color .2s, transform .2s; }
    .kt-back:hover { color: var(--bs-primary); transform: translateX(-3px); }

    .kt-card {
        border-radius: 1.5rem; overflow: hidden; background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color); border-top: 4px solid var(--bs-primary);
        box-shadow: 0 16px 40px rgba(13,110,253,.1);
    }
    .kt-card-head {
        display: flex; align-items: center; gap: .85rem;
        padding: 1.1rem clamp(1rem, 3vw, 1.75rem);
        background: var(--bs-tertiary-bg); border-bottom: 1px solid var(--bs-border-color);
    }
    .kt-icon {
        width: 46px; height: 46px; flex-shrink: 0; border-radius: 1rem;
        display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #fff;
        background: linear-gradient(135deg, #3d8bfd, #0a58ca); box-shadow: 0 8px 18px rgba(13,110,253,.3);
    }
    .kt-body { padding: clamp(1.1rem, 3.5vw, 2rem); }

    /* Input */
    .kt-input .input-group-text { color: var(--bs-primary); background: var(--bs-tertiary-bg); border-radius: .85rem 0 0 .85rem; padding-inline: 1rem; }
    .kt-input .form-control { padding-block: .75rem; border-radius: 0 .85rem .85rem 0; }
    .kt-input:focus-within .input-group-text,
    .kt-input:focus-within .form-control { border-color: var(--bs-primary); }
    .kt-input:focus-within { border-radius: .85rem; box-shadow: 0 0 0 .25rem rgba(13,110,253,.15); }
    .kt-input .form-control:focus { box-shadow: none; }

    /* Tombol */
    .kt-actions { display: flex; flex-direction: column-reverse; gap: .75rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px dashed var(--bs-border-color); }
    .kt-actions .btn { padding-block: .7rem; }
    @media (min-width: 576px) {
        .kt-actions { flex-direction: row; justify-content: flex-end; }
    }
    .kt-btn-primary {
        color: #fff; border: 0; background: linear-gradient(135deg, #0d6efd, #0a58ca);
        box-shadow: 0 10px 22px rgba(13,110,253,.35); transition: transform .2s, box-shadow .2s;
    }
    .kt-btn-primary:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 14px 28px rgba(13,110,253,.45); }
    .kt-btn-primary:disabled { opacity: .85; transform: none; }

    @media (prefers-reduced-motion: reduce) {
        .kt-back, .kt-btn-primary { transition: none; }
        .kt-back:hover, .kt-btn-primary:hover { transform: none; }
    }
</style>

<script>
    (function () {
        var form = document.getElementById('kategoriForm');
        var input = document.getElementById('nama_kategori');
        var count = document.getElementById('ktCount');
        var btn = document.getElementById('ktSubmit');
        if (!form || !input || !btn) return;

        // Penghitung karakter
        function updateCount() { count.textContent = input.value.length; }
        input.addEventListener('input', updateCount);
        updateCount();

        // Cegah klik ganda saat menyimpan
        form.addEventListener('submit', function () {
            if (!form.checkValidity()) return;
            btn.disabled = true;
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.querySelector('.kt-submit-icon').classList.add('d-none');
            btn.querySelector('.kt-submit-text').textContent = 'Menyimpan...';
        });

        // Kembalikan tombol jika halaman dibuka lewat tombol "Kembali" browser
        window.addEventListener('pageshow', function (e) {
            if (!e.persisted) return;
            btn.disabled = false;
            btn.querySelector('.spinner-border').classList.add('d-none');
            btn.querySelector('.kt-submit-icon').classList.remove('d-none');
            btn.querySelector('.kt-submit-text').textContent = 'Simpan';
            updateCount();
        });
    })();
</script>
@endsection