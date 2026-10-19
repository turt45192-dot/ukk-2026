@extends('layouts.app')

@section('title', 'Edit Alat')

@section('content')
<div class="container-fluid px-0 py-3">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">

            {{-- ===== Header ===== --}}
            <div class="mb-4 text-center text-sm-start">
                <a href="{{ route('alat.index') }}" class="al-back text-decoration-none d-inline-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-arrow-left"></i> Kembali ke daftar alat
                </a>
                <h1 class="al-title mb-1">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Edit Data Alat
                </h1>
                <p class="text-body-secondary mb-0">Perbarui rincian informasi dan inventaris sarana prasarana.</p>
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
            <div class="al-card">
                {{-- Ringkasan alat yang sedang diedit --}}
                <div class="al-card-head">
                    <div class="al-icon"><i class="bi bi-box-seam-fill"></i></div>
                    <div class="min-w-0 flex-grow-1">
                        <small class="text-body-secondary d-block">Sedang mengedit</small>
                        <h2 class="h6 fw-bold mb-1 text-truncate">{{ $data_alat->nama_alat }}</h2>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle">
                                <i class="bi bi-qr-code me-1"></i>{{ $data_alat->kode_alat }}
                            </span>
                            <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis border border-primary-subtle">
                                <i class="bi bi-hash me-1"></i>{{ $data_alat->jumlah }} unit
                            </span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('alat.update', ['alat' => $data_alat->id_alat]) }}" method="POST" id="alatForm" class="al-body">
                    @csrf
                    @method('PUT')

                    {{-- ---------- Bagian 1: Identitas ---------- --}}
                    <div class="al-section-label"><span>1</span> Identitas Alat</div>
                    <div class="row g-4 mb-4">
                        {{-- Kategori --}}
                        <div class="col-12 col-md-6">
                            <label for="id_kategori" class="form-label fw-semibold">Kategori Alat <span class="text-danger">*</span></label>
                            <div class="input-group al-input">
                                <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                                <select name="id_kategori" id="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id_kategori }}" {{ old('id_kategori', $data_alat->id_kategori) == $k->id_kategori ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('id_kategori')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kode --}}
                        <div class="col-12 col-md-6">
                            <label for="kode_alat" class="form-label fw-semibold">Kode Alat <span class="text-danger">*</span></label>
                            <div class="input-group al-input">
                                <span class="input-group-text"><i class="bi bi-qr-code"></i></span>
                                <input type="text" class="form-control @error('kode_alat') is-invalid @enderror" id="kode_alat" name="kode_alat"
                                       value="{{ old('kode_alat', $data_alat->kode_alat) }}" placeholder="Contoh: ALT-001" autocomplete="off" required>
                            </div>
                            @error('kode_alat')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <div class="col-12">
                            <label for="nama_alat" class="form-label fw-semibold">Nama Alat <span class="text-danger">*</span></label>
                            <div class="input-group al-input">
                                <span class="input-group-text"><i class="bi bi-tools"></i></span>
                                <input type="text" class="form-control @error('nama_alat') is-invalid @enderror" id="nama_alat" name="nama_alat"
                                       value="{{ old('nama_alat', $data_alat->nama_alat) }}" placeholder="Masukkan nama alat..." autocomplete="off" required>
                            </div>
                            @error('nama_alat')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ---------- Bagian 2: Kondisi & penyimpanan ---------- --}}
                    <div class="al-section-label"><span>2</span> Kondisi &amp; Penyimpanan</div>
                    <div class="row g-4">
                        {{-- Kondisi --}}
                        <div class="col-12 col-md-6">
                            <label for="kondisi" class="form-label fw-semibold">Kondisi <span class="text-danger">*</span></label>
                            <div class="input-group al-input">
                                <span class="input-group-text"><i class="bi bi-info-circle-fill"></i></span>
                                <input type="text" class="form-control @error('kondisi') is-invalid @enderror" id="kondisi" name="kondisi"
                                       value="{{ old('kondisi', $data_alat->kondisi) }}" placeholder="Contoh: Baik, Rusak Ringan" autocomplete="off" required>
                            </div>
                            <div class="al-quick" role="group" aria-label="Pilihan cepat kondisi">
                                <button type="button" class="al-quick-btn" data-fill="Baik">Baik</button>
                                <button type="button" class="al-quick-btn" data-fill="Rusak Ringan">Rusak Ringan</button>
                                <button type="button" class="al-quick-btn" data-fill="Rusak Berat">Rusak Berat</button>
                            </div>
                            @error('kondisi')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jumlah --}}
                        <div class="col-12 col-md-6">
                            <label for="jumlah" class="form-label fw-semibold">Jumlah Unit <span class="text-danger">*</span></label>
                            <div class="input-group al-input">
                                <button type="button" class="btn al-step" id="alMinus" aria-label="Kurangi jumlah"><i class="bi bi-dash-lg"></i></button>
                                <input type="number" min="0" inputmode="numeric" class="form-control text-center fw-bold @error('jumlah') is-invalid @enderror"
                                       id="jumlah" name="jumlah" value="{{ old('jumlah', $data_alat->jumlah) }}" placeholder="0" required>
                                <button type="button" class="btn al-step" id="alPlus" aria-label="Tambah jumlah"><i class="bi bi-plus-lg"></i></button>
                            </div>
                            @error('jumlah')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Lokasi --}}
                        <div class="col-12">
                            <label for="lokasi" class="form-label fw-semibold">Lokasi Penyimpanan <span class="text-danger">*</span></label>
                            <div class="input-group al-input">
                                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi"
                                       value="{{ old('lokasi', $data_alat->lokasi) }}" placeholder="Contoh: Lab Komputer 1, Gudang Utama" autocomplete="off" required>
                            </div>
                            @error('lokasi')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Info perubahan --}}
                    <div id="alDirtyHint" class="al-hint d-none" role="status">
                        <i class="bi bi-info-circle-fill"></i> Ada perubahan yang belum disimpan.
                    </div>

                    {{-- Aksi --}}
                    <div class="al-actions">
                        <a href="{{ route('alat.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">Batal</a>
                        <button type="submit" id="alSubmit" class="btn al-btn-primary rounded-pill px-4 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                            <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                            <i class="bi bi-floppy-fill al-submit-icon"></i>
                            <span class="al-submit-text">Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .min-w-0 { min-width: 0; }
    .al-title { font-size: clamp(1.4rem, 1.1rem + 1.4vw, 2rem); font-weight: 800; letter-spacing: -.01em; }
    .al-back { font-size: .9rem; font-weight: 600; color: var(--bs-secondary-color); transition: color .2s, transform .2s; }
    .al-back:hover { color: var(--bs-primary); transform: translateX(-3px); }

    .al-card {
        border-radius: 1.5rem; overflow: hidden; background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color); border-top: 4px solid var(--bs-warning);
        box-shadow: 0 16px 40px rgba(13,110,253,.1);
    }
    .al-card-head {
        display: flex; align-items: center; gap: 1rem;
        padding: 1.1rem clamp(1rem, 3vw, 1.75rem);
        background: var(--bs-tertiary-bg); border-bottom: 1px solid var(--bs-border-color);
    }
    .al-icon {
        width: 50px; height: 50px; flex-shrink: 0; border-radius: 1rem;
        display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #fff;
        background: linear-gradient(135deg, #3d8bfd, #0a58ca); box-shadow: 0 8px 18px rgba(13,110,253,.3);
    }
    .al-body { padding: clamp(1.1rem, 3.5vw, 2rem); }

    /* Judul bagian */
    .al-section-label {
        display: flex; align-items: center; gap: .6rem; margin-bottom: 1.1rem;
        font-size: .78rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; color: var(--bs-secondary-color);
    }
    .al-section-label span {
        width: 24px; height: 24px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
        font-size: .75rem; color: #fff; background: var(--bs-primary);
    }
    .al-section-label::after { content: ""; flex: 1; border-top: 1px dashed var(--bs-border-color); }

    /* Input */
    .al-input .input-group-text { color: var(--bs-primary); background: var(--bs-tertiary-bg); border-radius: .85rem 0 0 .85rem; padding-inline: 1rem; }
    .al-input .form-control, .al-input .form-select { padding-block: .75rem; border-radius: 0 .85rem .85rem 0; }
    .al-input:focus-within .input-group-text,
    .al-input:focus-within .form-control,
    .al-input:focus-within .form-select,
    .al-input:focus-within .al-step { border-color: var(--bs-primary); }
    .al-input:focus-within { border-radius: .85rem; box-shadow: 0 0 0 .25rem rgba(13,110,253,.15); }
    .al-input .form-control:focus, .al-input .form-select:focus { box-shadow: none; }

    /* Kolom yang sudah diubah (tanda kuning) */
    .al-input.is-dirty:not(:focus-within) .input-group-text,
    .al-input.is-dirty:not(:focus-within) .form-control,
    .al-input.is-dirty:not(:focus-within) .form-select,
    .al-input.is-dirty:not(:focus-within) .al-step { border-color: var(--bs-warning); }

    /* Stepper jumlah */
    .al-input .al-step {
        min-width: 48px; color: var(--bs-primary); background: var(--bs-tertiary-bg);
        border: 1px solid var(--bs-border-color);
    }
    .al-input .al-step:first-child { border-radius: .85rem 0 0 .85rem; }
    .al-input .al-step:last-child { border-radius: 0 .85rem .85rem 0; }
    .al-input .al-step:hover { color: #fff; background: var(--bs-primary); border-color: var(--bs-primary); }
    .al-input input[type=number] { border-radius: 0; -moz-appearance: textfield; }
    .al-input input[type=number]::-webkit-outer-spin-button,
    .al-input input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

    /* Pilihan cepat kondisi */
    .al-quick { display: flex; flex-wrap: wrap; gap: .4rem; margin-top: .6rem; }
    .al-quick-btn {
        padding: .25rem .8rem; border-radius: 999px; font-size: .78rem; font-weight: 600;
        color: var(--bs-body-color); background: var(--bs-body-bg); border: 1px solid var(--bs-border-color);
        transition: all .2s;
    }
    .al-quick-btn:hover { color: var(--bs-primary); border-color: var(--bs-primary); }
    .al-quick-btn.active { color: #fff; background: var(--bs-primary); border-color: var(--bs-primary); }

    .al-hint {
        margin-top: 1.5rem; padding: .7rem 1rem; border-radius: .85rem; font-size: .875rem; font-weight: 600;
        color: var(--bs-warning-text-emphasis); background: var(--bs-warning-bg-subtle);
        border: 1px solid var(--bs-warning-border-subtle);
    }

    /* Tombol */
    .al-actions { display: flex; flex-direction: column-reverse; gap: .75rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px dashed var(--bs-border-color); }
    .al-actions .btn { padding-block: .7rem; }
    @media (min-width: 576px) {
        .al-actions { flex-direction: row; justify-content: flex-end; }
    }
    .al-btn-primary {
        color: #fff; border: 0; background: linear-gradient(135deg, #0d6efd, #0a58ca);
        box-shadow: 0 10px 22px rgba(13,110,253,.35); transition: transform .2s, box-shadow .2s;
    }
    .al-btn-primary:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 14px 28px rgba(13,110,253,.45); }
    .al-btn-primary:disabled { opacity: .85; transform: none; }

    @media (prefers-reduced-motion: reduce) {
        .al-back, .al-btn-primary, .al-quick-btn { transition: none; }
        .al-back:hover, .al-btn-primary:hover { transform: none; }
    }
</style>

<script>
    (function () {
        var form = document.getElementById('alatForm');
        var btn = document.getElementById('alSubmit');
        var hint = document.getElementById('alDirtyHint');
        var kondisi = document.getElementById('kondisi');
        var jumlah = document.getElementById('jumlah');
        if (!form || !btn) return;

        // Nilai awal dari database sebagai pembanding perubahan
        var original = {
            id_kategori: {!! json_encode((string) ($data_alat->id_kategori ?? '')) !!},
            kode_alat:   {!! json_encode((string) ($data_alat->kode_alat ?? '')) !!},
            nama_alat:   {!! json_encode((string) ($data_alat->nama_alat ?? '')) !!},
            kondisi:     {!! json_encode((string) ($data_alat->kondisi ?? '')) !!},
            jumlah:      {!! json_encode((string) ($data_alat->jumlah ?? '')) !!},
            lokasi:      {!! json_encode((string) ($data_alat->lokasi ?? '')) !!}
        };
        var fields = form.querySelectorAll('input[name], select[name]');

        function checkDirty() {
            var any = false;
            fields.forEach(function (el) {
                if (!(el.name in original)) return;
                var changed = el.value !== original[el.name];
                var group = el.closest('.al-input');
                if (group) group.classList.toggle('is-dirty', changed);
                if (changed) any = true;
            });
            hint.classList.toggle('d-none', !any);
            return any;
        }
        fields.forEach(function (el) {
            el.addEventListener('input', checkDirty);
            el.addEventListener('change', checkDirty);
        });

        // Pilihan cepat kondisi
        var quick = document.querySelectorAll('.al-quick-btn');
        function markQuick() {
            var v = kondisi.value.trim().toLowerCase();
            quick.forEach(function (b) { b.classList.toggle('active', b.dataset.fill.toLowerCase() === v); });
        }
        quick.forEach(function (b) {
            b.addEventListener('click', function () {
                kondisi.value = b.dataset.fill; markQuick(); checkDirty(); kondisi.focus();
            });
        });
        kondisi.addEventListener('input', markQuick);
        markQuick();

        // Tombol + dan - untuk jumlah (minimal 0)
        function current() { var n = parseInt(jumlah.value, 10); return isNaN(n) ? 0 : n; }
        document.getElementById('alMinus').addEventListener('click', function () { jumlah.value = Math.max(0, current() - 1); checkDirty(); });
        document.getElementById('alPlus').addEventListener('click', function () { jumlah.value = current() + 1; checkDirty(); });

        checkDirty();

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
            btn.querySelector('.al-submit-icon').classList.add('d-none');
            btn.querySelector('.al-submit-text').textContent = 'Menyimpan...';
        });

        // Kembalikan tombol jika halaman dibuka lewat tombol "Kembali" browser
        window.addEventListener('pageshow', function (e) {
            if (!e.persisted) return;
            submitting = false;
            btn.disabled = false;
            btn.querySelector('.spinner-border').classList.add('d-none');
            btn.querySelector('.al-submit-icon').classList.remove('d-none');
            btn.querySelector('.al-submit-text').textContent = 'Simpan Perubahan';
            checkDirty();
        });
    })();
</script>
@endsection