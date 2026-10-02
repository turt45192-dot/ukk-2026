@extends('layouts.app')

@section('title', 'Daftar Alat & Fasilitas')

@php
    $currentUser = class_exists('\App\Models\User') && method_exists('\App\Models\User', 'current') 
        ? \App\Models\User::current() 
        : auth()->user();
    
    // Cek apakah user berhak menambah/mengedit data (bukan siswa)
    $canManage = $currentUser && isset($currentUser->role) && $currentUser->role !== 'siswa';
@endphp

@push('styles')
<style>
    .hover-shadow {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2">

    {{-- Header & Tombol Tambah --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1 text-body">Daftar Alat & Fasilitas</h2>
            <p class="text-body-secondary small mb-0">Kelola dan pantau inventaris sarana prasarana sekolah.</p>
        </div>

        @if($canManage)
            <a href="{{ route('alat.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 fw-semibold px-3 py-2 rounded-3 shadow-sm hover-shadow">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Tambah Alat</span>
            </a>
        @endif
    </div>

    {{-- Alert Notifikasi Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel Data --}}
    <div class="card border bg-body-tertiary shadow-sm rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-body-tertiary border-bottom">
                        <tr class="text-body-secondary small fw-semibold text-uppercase">
                            <th class="ps-4 py-3" style="width: 60px;">No</th>
                            <th class="py-3" style="min-width: 140px;">Kategori</th>
                            <th class="py-3" style="min-width: 180px;">Nama Alat</th>
                            <th class="py-3" style="min-width: 120px;">Kode Alat</th>
                            <th class="py-3" style="min-width: 130px;">Kondisi</th>
                            <th class="py-3 text-center" style="width: 100px;">Jumlah</th>
                            <th class="py-3" style="min-width: 160px;">Lokasi</th>
                            @if($canManage)
                                <th class="pe-4 py-3 text-end" style="min-width: 140px;">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-body">
                        @forelse ($data as $index => $d)
                            <tr>
                                {{-- Nomor Urut --}}
                                <td class="ps-4 fw-medium text-body-secondary">
                                    {{ method_exists($data, 'firstItem') ? $data->firstItem() + $index : $index + 1 }}
                                </td>

                                {{-- Kategori --}}
                                <td>
                                    <span class="badge bg-body-tertiary text-body border px-2.5 py-1.5 fw-normal">
                                        <i class="bi bi-tag-fill me-1 text-primary"></i>
                                        {{ $d->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>

                                {{-- Nama Alat --}}
                                <td>
                                    <span class="fw-semibold text-body">{{ $d->nama_alat }}</span>
                                </td>

                                {{-- Kode Alat --}}
                                <td>
                                    <code class="px-2 py-1 rounded bg-body-tertiary border text-primary font-monospace fs-7">
                                        {{ $d->kode_alat }}
                                    </code>
                                </td>

                                {{-- Kondisi Dinamis --}}
                                <td>
                                    @php
                                        $kondisi = strtolower($d->kondisi);
                                    @endphp

                                    @if(str_contains($kondisi, 'baik'))
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded-pill fw-medium d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-check-circle-fill"></i> {{ $d->kondisi }}
                                        </span>
                                    @elseif(str_contains($kondisi, 'ringan'))
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1.5 rounded-pill fw-medium d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-exclamation-triangle-fill"></i> {{ $d->kondisi }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1.5 rounded-pill fw-medium d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-x-circle-fill"></i> {{ $d->kondisi }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Jumlah --}}
                                <td class="text-center">
                                    <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1.5 rounded-3 fw-semibold">
                                        {{ $d->jumlah }}
                                    </span>
                                </td>

                                {{-- Lokasi --}}
                                <td>
                                    <span class="text-body-secondary small d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-geo-alt-fill text-danger"></i>
                                        {{ $d->lokasi }}
                                    </span>
                                </td>

                                {{-- Tombol Aksi --}}
                                @if($canManage)
                                    <td class="pe-4 text-end">
                                        <div class="d-inline-flex gap-1">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('alat.edit', ['alat' => $d->id_alat]) }}" class="btn btn-sm btn-warning text-dark rounded-2 d-inline-flex align-items-center gap-1" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                                <span class="d-none d-xl-inline">Edit</span>
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('alat.destroy', ['alat' => $d->id_alat]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger rounded-2 d-inline-flex align-items-center gap-1" title="Hapus">
                                                    <i class="bi bi-trash-fill"></i>
                                                    <span class="d-none d-xl-inline">Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $canManage ? 8 : 7 }}" class="text-center py-5">
                                    <div class="text-body-secondary">
                                        <i class="bi bi-tools fs-1 d-block mb-2 text-body-tertiary"></i>
                                        <h6 class="fw-semibold text-body">Belum Ada Data Alat</h6>
                                        <p class="small mb-0">Silakan tambahkan data alat inventaris baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination Footer --}}
        @if(method_exists($data, 'hasPages') && $data->hasPages())
            <div class="card-footer bg-body-tertiary border-top py-3 px-4">
                <div class="d-flex justify-content-end">
                    {!! $data->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection