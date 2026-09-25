@extends('layouts.app')

@section('content')

<h1>Tambah Alat</h1>
<form action="{{ route('alat.store') }}" method="POST">
    @csrf
    <div class="form-group mb-3">
        <label>Kategori Alat</label>
        <select name="id_kategori" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($kategori as $k)
                <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
            @endforeach
        </select>

        <label class="mt-2">Nama Alat</label>
        <input type="text" name="nama_alat" class="form-control" required>
        
        <label class="mt-2">Kode Alat</label>
        <input type="text" name="kode_alat" class="form-control" required>
        
        <label class="mt-2">Kondisi</label>
        <input type="text" name="kondisi" class="form-control" required>
        
        <label class="mt-2">Jumlah</label>
        <input type="number" name="jumlah" class="form-control" required>
        
        <label class="mt-2">Lokasi</label>
        <input type="text" name="lokasi" class="form-control" required>
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('alat.index') }}" class="btn btn-secondary">Batal</a>
</form>

@endsection