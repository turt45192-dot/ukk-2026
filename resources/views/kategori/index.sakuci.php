@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header & Tombol Tambah --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-1">Manajemen Kategori</h2>
            <p class="text-secondary small mb-0">Kelola daftar kategori inventaris dan alat</p>
        </div>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary rounded-3">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </a>
    </div>

    {{-- Kartu Tabel Data --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" width="80">No</th>
                            <th>Kode Kategori</th>
                            <th>Nama Kategori</th>
                            <th class="text-center" width="220">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $key => $d)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ method_exists($data, 'firstItem') ? $data->firstItem() + $key : $key + 1 }}</td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill">
                                    {{ $d->kode_kategori }}
                                </span>
                            </td>
                            <td class="fw-semibold text-capitalize">{{ $d->nama_kategori }}</td>
                            <td class="text-center">
                                <div class="btn-group gap-1" role="group">
                                    <a href="{{ route('alat.index', ['kategori' => $d->id_kategori]) }}" class="btn btn-info btn-sm text-white rounded-2" title="Lihat Daftar Alat">
                                        Lihat Alat
                                    </a>

                                    <a href="{{ route('kategori.edit', ['kategori' => $d->id_kategori]) }}" class="btn btn-warning btn-sm rounded-2" title="Edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('kategori.destroy', ['kategori' => $d->id_kategori]) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-2" onclick="return confirm('Yakin hapus kategori ini?')" title="Hapus">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada data kategori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Footer Pagination (Diubah ke justify-content-end agar rata kanan) --}}
        @if(method_exists($data, 'links'))
        <div class="card-footer bg-transparent border-0 py-3 px-4 d-flex justify-content-end">
            {!! $data->links() !!}
        </div>
        @endif
    </div>

</div>
@endsection