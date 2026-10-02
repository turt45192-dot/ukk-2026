@extends('layouts.app')

@section('title', 'Tambah Alat')

@push('styles')
<style>
    .hover-shadow {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }
    
    /* Penyesuaian Input Group Icon agar fleksibel di Dark/Light Mode */
    .input-group-text-theme {
        background-color: var(--bs-tertiary-bg);
        color: var(--bs-secondary-color);
        border-color: var(--bs-border-color);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

    {{-- Header & Tombol Kembali --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1 text-body">Tambah Alat Baru</h2>
            <p class="text-body-secondary small mb-0">Tambahkan inventaris alat atau fasilitas baru ke dalam sistem.</p>
        </div>
        <a href="{{ route('alat.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 fw-semibold px-3 py-2 rounded-3 shadow-sm">
            <i class="bi bi-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Form Card --}}
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card border bg-body-tertiary shadow-sm rounded-3">
                <div class="card-header bg-body border-bottom py-3 px-4">
                    <h5 class="card-title fw-bold text-body mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle-fill text-primary"></i> Form Inventaris Alat
                    </h5>
                </div>

                <div class="card-body p-4 bg-body">
                    <form action="{{ route('alat.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            {{-- 1. Kategori Alat --}}
                            <div class="col-md-6 mb-2">
                                <label for="id_kategori" class="form-label fw-semibold text-body">
                                    Kategori Alat <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-theme"><i class="bi bi-tag-fill"></i></span>
                                    <select name="id_kategori" id="id_kategori" class="form-select bg-body text-body border-secondary-subtle @error('id_kategori') is-invalid @enderror" required>
                                        <option value="" class="bg-body text-body">-- Pilih Kategori --</option>
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id_kategori }}" class="bg-body text-body" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                                                {{ $k->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('id_kategori')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 2. Kode Alat --}}
                            <div class="col-md-6 mb-2">
                                <label for="kode_alat" class="form-label fw-semibold text-body">
                                    Kode Alat <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-theme"><i class="bi bi-qr-code"></i></span>
                                    <input type="text" class="form-control bg-body text-body border-secondary-subtle @error('kode_alat') is-invalid @enderror" id="kode_alat" name="kode_alat" value="{{ old('kode_alat') }}" placeholder="Contoh: ALT-001" required>
                                </div>
                                @error('kode_alat')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 3. Nama Alat --}}
                            <div class="col-12 mb-2">
                                <label for="nama_alat" class="form-label fw-semibold text-body">
                                    Nama Alat <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-theme"><i class="bi bi-tools"></i></span>
                                    <input type="text" class="form-control bg-body text-body border-secondary-subtle @error('nama_alat') is-invalid @enderror" id="nama_alat" name="nama_alat" value="{{ old('nama_alat') }}" placeholder="Masukkan nama alat..." required>
                                </div>
                                @error('nama_alat')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 4. Kondisi --}}
                            <div class="col-md-6 mb-2">
                                <label for="kondisi" class="form-label fw-semibold text-body">
                                    Kondisi <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-theme"><i class="bi bi-info-circle-fill"></i></span>
                                    <input type="text" class="form-control bg-body text-body border-secondary-subtle @error('kondisi') is-invalid @enderror" id="kondisi" name="kondisi" value="{{ old('kondisi') }}" placeholder="Contoh: Baik, Rusak Ringan" required>
                                </div>
                                @error('kondisi')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 5. Jumlah --}}
                            <div class="col-md-6 mb-2">
                                <label for="jumlah" class="form-label fw-semibold text-body">
                                    Jumlah Unit <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-theme"><i class="bi bi-hash"></i></span>
                                    <input type="number" min="1" class="form-control bg-body text-body border-secondary-subtle @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" placeholder="0" required>
                                </div>
                                @error('jumlah')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- 6. Lokasi --}}
                            <div class="col-12 mb-3">
                                <label for="lokasi" class="form-label fw-semibold text-body">
                                    Lokasi Penyimpanan <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-theme"><i class="bi bi-geo-alt-fill"></i></span>
                                    <input type="text" class="form-control bg-body text-body border-secondary-subtle @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" placeholder="Contoh: Lab Komputer 1, Gudang Utama" required>
                                </div>
                                @error('lokasi')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="pt-3 border-top d-flex gap-2 justify-content-end">
                            <a href="{{ route('alat.index') }}" class="btn btn-outline-secondary px-4 rounded-3 fw-semibold">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 rounded-3 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm hover-shadow">
                                <i class="bi bi-floppy-fill"></i>
                                <span>Simpan Data</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection