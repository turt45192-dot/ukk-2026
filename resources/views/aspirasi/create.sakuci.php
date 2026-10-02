@extends('layouts.app')

@section('content')
    <h1>Tambah Aspirasi</h1>

    <form action="{{ route('aspirasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 1. Dropdown Kategori -->
        <div class="form-group mb-3">
            <label for="id_kategori">Kategori</label>
            <select name="id_kategori" id="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $kat)
                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <!-- 2. Input Judul -->
        <div class="form-group mb-3">
            <label for="judul">Judul Aspirasi</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul aspirasi" required>
        </div>

        <!-- 3. Input Deskripsi -->
        <div class="form-group mb-3">
            <label for="deskripsi">Deskripsi Detail</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan detail pengaduan..." required></textarea>
        </div>

        <!-- 4. Upload Foto Bukti -->
        <div class="form-group mb-3">
            <label for="foto">Foto Bukti (Opsional)</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('aspirasi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection