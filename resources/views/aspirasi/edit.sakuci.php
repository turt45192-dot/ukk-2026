@extends('layouts.app')

@section('content')
    <h1>Edit Aspirasi</h1>

    <form action="{{ route('aspirasi.update', ['id_aspirasi' => $aspirasi->id_aspirasi]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- 1. Kategori -->
        <div class="form-group mb-3">
            <label for="id_kategori">Kategori</label>
            <select name="id_kategori" id="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $kat)
                    <option value="{{ $kat->id_kategori }}" {{ $aspirasi->id_kategori == $kat->id_kategori ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- 2. Judul -->
        <div class="form-group mb-3">
            <label for="judul">Judul Aspirasi</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ $aspirasi->judul }}" required>
        </div>

        <!-- 3. Deskripsi -->
        <div class="form-group mb-3">
            <label for="deskripsi">Deskripsi Detail</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ $aspirasi->deskripsi }}</textarea>
        </div>

        <!-- 4. Pratinjau & Ubah Foto -->
        <div class="form-group mb-3">
            <label for="foto">Foto Bukti</label>
            @if($aspirasi->foto)
                <div class="mb-2">
                    <img src="{{ asset('uploads/aspirasi/' . $aspirasi->foto) }}" alt="Foto Bukti" width="120" class="rounded">
                </div>
            @endif
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('aspirasi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection