@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
@php
    // Pakai old() jika tersedia, jika tidak pakai data dari database
    $val = function ($key) use ($siswa) {
        $old = function_exists('old') ? old($key) : null;
        return ($old !== null && $old !== '') ? $old : ($siswa->$key ?? '');
    };

    // Inisial nama untuk avatar
    $namaAwal = trim((string) ($siswa->nama ?? ''));
    $inisial = $namaAwal === '' ? '?' : (function_exists('mb_substr')
        ? mb_strtoupper(mb_substr($namaAwal, 0, 1))
        : strtoupper(substr($namaAwal, 0, 1)));
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
                    <i class="bi bi-pencil-square text-warning me-2"></i>Edit Pengguna
                </h1>
                <p class="text-body-secondary mb-0">Perbarui data pengguna, lalu tekan tombol simpan.</p>
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
                {{-- Profil singkat pengguna yang sedang diedit --}}
                <div class="pg-card-head">
                    <div class="pg-avatar" aria-hidden="true">{{ $inisial }}</div>
                    <div class="min-w-0 flex-grow-1">
                        <h2 class="h6 fw-bold mb-1 text-truncate">{{ $siswa->nama }}</h2>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis border border-primary-subtle">
                                <i class="bi bi-card-heading me-1"></i>NIS {{ $siswa->nis }}
                            </span>
                            <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle">
                                <i class="bi bi-mortarboard me-1"></i>{{ $siswa->kelas }}
                            </span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('pengguna.update', ['pengguna' => $siswa->id_siswa]) }}" method="POST" id="penggunaForm" class="pg-body">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        {{-- Nama --}}
                        <div class="col-12">
                            <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                            <div class="input-group pg-input">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" id="nama" name="nama" class="form-control"
                                       placeholder="Nama lengkap" value="{{ $val('nama') }}"
                                       autocomplete="name" required>
                            </div>
                        </div>

                        {{-- NIS --}}
                        <div class="col-12 col-md-6">
                            <label for="nis" class="form-label fw-semibold">NIS</label>
                            <div class="input-group pg-input">
                                <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                <input type="text" id="nis" name="nis" class="form-control"
                                       placeholder="Nomor Induk Siswa" value="{{ $val('nis') }}"
                                       inputmode="numeric" autocomplete="off" required>
                            </div>
                        </div>

                        {{-- Kelas --}}
                        <div class="col-12 col-md-6">
                            <label for="kelas" class="form-label fw-semibold">Kelas</label>
                            <div class="input-group pg-input">
                                <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                                <input type="text" id="kelas" name="kelas" class="form-control"
                                       placeholder="Contoh: XII RPL 1" value="{{ $val('kelas') }}"
                                       autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    {{-- Info perubahan --}}
                    <div id="pgDirtyHint" class="pg-hint d-none" role="status">
                        <i class="bi bi-info-circle-fill"></i> Ada perubahan yang belum disimpan.
                    </div>

                    {{-- Aksi --}}
                    <div class="pg-actions">
                        <a href="{{ route('pengguna.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
                            Batal
                        </a>
                        <button type="submit" id="pgSubmit" class="btn pg-btn-primary rounded-pill px-4 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                            <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                            <i class="bi bi-check2-circle pg-submit-icon"></i>
                            <span class="pg-submit-text">Simpan Perubahan</span>
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
        border: 1px solid var(--bs-border-color); border-top: 4px solid var(--bs-warning);
        box-shadow: 0 16px 40px rgba(13,110,253,.1);
    }
    .pg-card-head {
        display: flex; align-items: center; gap: 1rem;
        padding: 1.1rem clamp(1rem, 3vw, 1.75rem);
        background: var(--bs-tertiary-bg); border-bottom: 1px solid var(--bs-border-color);
    }
    .pg-avatar {
        width: 54px; height: 54px; flex-shrink: 0; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; font-weight: 800; color: #fff;
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
    .pg-input.is-dirty .form-control { border-color: var(--bs-warning); }
    .pg-input.is-dirty .input-group-text { border-color: var(--bs-warning); }

    .pg-hint {
        margin-top: 1.5rem; padding: .7rem 1rem; border-radius: .85rem; font-size: .875rem; font-weight: 600;
        color: var(--bs-warning-text-emphasis); background: var(--bs-warning-bg-subtle);
        border: 1px solid var(--bs-warning-border-subtle);
    }

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
    (function () {
        var form = document.getElementById('penggunaForm');
        var btn = document.getElementById('pgSubmit');
        var hint = document.getElementById('pgDirtyHint');
        if (!form || !btn) return;

        var inputs = form.querySelectorAll('input[type="text"]');
        var original = {};
        inputs.forEach(function (el) { original[el.name] = el.value; });

        // Tandai kolom yang berubah & tampilkan pengingat
        function checkDirty() {
            var any = false;
            inputs.forEach(function (el) {
                var changed = el.value !== original[el.name];
                var group = el.closest('.pg-input');
                if (group) group.classList.toggle('is-dirty', changed);
                if (changed) any = true;
            });
            hint.classList.toggle('d-none', !any);
            return any;
        }
        inputs.forEach(function (el) { el.addEventListener('input', checkDirty); });

        // Peringatan jika keluar halaman dengan perubahan belum disimpan
        var submitting = false;
        window.addEventListener('beforeunload', function (e) {
            if (!submitting && checkDirty()) { e.preventDefault(); e.returnValue = ''; }
        });

        // Cegah klik ganda saat menyimpan
        form.addEventListener('submit', function () {
            if (!form.checkValidity()) return;
            submitting = true;
            btn.disabled = true;
            btn.querySelector('.spinner-border').classList.remove('d-none');
            btn.querySelector('.pg-submit-icon').classList.add('d-none');
            btn.querySelector('.pg-submit-text').textContent = 'Menyimpan...';
        });

        // Kembalikan tombol jika halaman dibuka lewat tombol "Kembali" browser
        window.addEventListener('pageshow', function (e) {
            if (!e.persisted) return;
            submitting = false;
            btn.disabled = false;
            btn.querySelector('.spinner-border').classList.add('d-none');
            btn.querySelector('.pg-submit-icon').classList.remove('d-none');
            btn.querySelector('.pg-submit-text').textContent = 'Simpan Perubahan';
        });
    })();
</script>
@endsection