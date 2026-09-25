@extends('layouts.app')

@section('content')
<h1>Edit Alat</h1>

<form action="{{ route('alat.update', ['alat' => $data_alat->id_alat]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group mb-3">
        <label for="id_kategori">Kategori Alat</label>
        <select name="id_kategori" class="form-control" id="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($kategori as $k)
                <option value="{{ $k->id_kategori }}" {{ $data_alat->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                    {{ $k->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="nama_alat">Nama Alat</label>
        <input type="text" class="form-control" id="nama_alat" name="nama_alat" value="{{ $data_alat->nama_alat }}" required>
    </div>

    <div class="form-group mb-3">
        <label for="kode_alat">Kode Alat</label>
        <input type="text" class="form-control" id="kode_alat" name="kode_alat" value="{{ $data_alat->kode_alat }}" required>
    </div>

    <div class="form-group mb-3">
        <label for="kondisi">Kondisi</label>
        <input type="text" class="form-control" id="kondisi" name="kondisi" value="{{ $data_alat->kondisi }}" required>
    </div>

    <div class="form-group mb-3">
        <label for="jumlah">Jumlah</label>
        <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $data_alat->jumlah }}" required>
    </div>

    <div class="form-group mb-3">
        <label for="lokasi">Lokasi</label>
        <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $data_alat->lokasi }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('alat.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection