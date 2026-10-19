@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
@php
    // Ubah $data menjadi array biasa (framework ini tidak punya helper collect())
    $list = [];
    if (is_array($data ?? null)) {
        $list = array_values($data);
    } elseif (is_iterable($data ?? null)) {
        foreach ($data as $row) { $list[] = $row; }
    }

    // Nomor awal (mengikuti halaman jika memakai pagination)
    $startNo = 1;
    if (is_object($data) && method_exists($data, 'firstItem')) {
        $startNo = $data->firstItem() ?: 1;
    }

    // Total data
    $total = count($list);
    if (is_object($data) && method_exists($data, 'total')) {
        $total = $data->total() ?: $total;
    }
@endphp

<div class="container-fluid px-0 py-3">

    {{-- ===== Header ===== --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h1 class="kg-title mb-1"><i class="bi bi-grid-fill text-primary me-2"></i>Manajemen Kategori</h1>
            <p class="text-body-secondary mb-0">Kelola daftar kategori inventaris dan alat.</p>
        </div>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
        </a>
    </div>

    {{-- ===== Notifikasi ===== --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- ===== Ringkasan & pencarian ===== --}}
    <div class="kg-toolbar mb-4">
        <div class="kg-stat">
            <div class="kg-stat-icon bg-primary-subtle text-primary"><i class="bi bi-tags-fill"></i></div>
            <div><div class="kg-stat-num">{{ $total }}</div><small class="text-body-secondary">Total Kategori</small></div>
        </div>
        <div class="input-group kg-search">
            <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-body-secondary"></i></span>
            <input type="search" id="kgSearch" class="form-control border-start-0 ps-0" placeholder="Cari kode atau nama kategori..." aria-label="Cari kategori">
        </div>
    </div>

    {{-- ===== Tampilan TABEL (layar >= 768px) ===== --}}
    <div class="kg-panel d-none d-md-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:72px">No</th>
                        <th>Kode</th>
                        <th>Nama Kategori</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = $startNo; @endphp
                    @foreach ($list as $d)
                        <tr class="kg-item" data-search="{{ strtolower($d->kode_kategori . ' ' . $d->nama_kategori) }}">
                            <td class="ps-4 text-body-secondary fw-semibold">{{ $no++ }}</td>
                            <td>
                                <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle px-3 py-2">
                                    {{ $d->kode_kategori }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="kg-dot"><i class="bi bi-tag-fill"></i></div>
                                    <span class="fw-bold text-capitalize">{{ $d->nama_kategori }}</span>
                                </div>
                            </td>
                            <td class="text-end pe-4 text-nowrap">
                                <a href="{{ route('alat.index', ['kategori' => $d->id_kategori]) }}" class="btn btn-sm btn-outline-info rounded-pill px-3" title="Lihat Daftar Alat">
                                    <i class="bi bi-tools"></i> Lihat Alat
                                </a>
                                <a href="{{ route('kategori.edit', ['kategori' => $d->id_kategori]) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3" title="Edit">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('kategori.destroy', ['kategori' => $d->id_kategori]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kategori {{ addslashes($d->nama_kategori) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Hapus">
                                        <i class="bi bi-trash3"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== Tampilan KARTU (layar < 768px) ===== --}}
    <div class="row g-3 d-md-none">
        @foreach ($list as $d)
            <div class="col-12 kg-item" data-search="{{ strtolower($d->kode_kategori . ' ' . $d->nama_kategori) }}">
                <article class="kg-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="kg-dot lg"><i class="bi bi-tag-fill"></i></div>
                        <div class="min-w-0">
                            <h2 class="h6 fw-bold mb-1 text-capitalize text-truncate">{{ $d->nama_kategori }}</h2>
                            <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle">
                                <i class="bi bi-upc-scan me-1"></i>{{ $d->kode_kategori }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('alat.index', ['kategori' => $d->id_kategori]) }}" class="btn btn-outline-info rounded-pill w-100 fw-semibold mb-2">
                        <i class="bi bi-tools me-1"></i>Lihat Alat
                    </a>
                    <div class="d-flex gap-2">
                        <a href="{{ route('kategori.edit', ['kategori' => $d->id_kategori]) }}" class="btn btn-outline-warning rounded-pill flex-fill fw-semibold">
                            <i class="bi bi-pencil-square me-1"></i>Edit
                        </a>
                        <form action="{{ route('kategori.destroy', ['kategori' => $d->id_kategori]) }}" method="POST" class="flex-fill" onsubmit="return confirm('Yakin hapus kategori {{ addslashes($d->nama_kategori) }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger rounded-pill w-100 fw-semibold">
                                <i class="bi bi-trash3 me-1"></i>Hapus
                            </button>
                        </form>
                    </div>
                </article>
            </div>
        @endforeach
    </div>

    {{-- ===== Keadaan kosong ===== --}}
    <div id="kgEmpty" class="kg-empty text-center {{ count($list) ? 'd-none' : '' }}">
        <div class="kg-empty-icon"><i class="bi bi-grid"></i></div>
        <h2 class="h5 fw-bold" id="kgEmptyTitle">Belum ada data kategori</h2>
        <p class="text-body-secondary mb-3" id="kgEmptyText">Mulai dengan menambahkan kategori pertama.</p>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary rounded-pill px-4" id="kgEmptyBtn">
            <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
        </a>
    </div>

    {{-- ===== Pagination (rata kanan, sesuai file Anda) ===== --}}
    @if (is_object($data) && method_exists($data, 'links'))
        <div class="mt-4 d-flex justify-content-end overflow-auto">{!! $data->links() !!}</div>
    @endif
</div>

<style>
    .min-w-0 { min-width: 0; }
    .kg-title { font-size: clamp(1.4rem, 1.1rem + 1.4vw, 2rem); font-weight: 800; letter-spacing: -.01em; }

    /* Ringkasan + pencarian */
    .kg-toolbar { display: flex; flex-direction: column; gap: .85rem; }
    @media (min-width: 576px) {
        .kg-toolbar { flex-direction: row; align-items: center; justify-content: space-between; }
    }
    .kg-stat {
        display: flex; align-items: center; gap: .85rem; padding: .85rem 1.1rem;
        border-radius: 1rem; background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color); box-shadow: 0 2px 10px rgba(0,0,0,.04);
    }
    .kg-stat-icon { width: 44px; height: 44px; flex-shrink: 0; border-radius: .85rem; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .kg-stat-num { font-size: 1.5rem; font-weight: 800; line-height: 1; }
    .kg-search { max-width: 420px; }
    @media (max-width: 575.98px) { .kg-search { max-width: none; } }
    .kg-search .input-group-text, .kg-search .form-control { border-radius: 999px; padding-block: .65rem; }
    .kg-search .input-group-text { border-top-right-radius: 0; border-bottom-right-radius: 0; padding-left: 1.1rem; }
    .kg-search .form-control { border-top-left-radius: 0; border-bottom-left-radius: 0; }

    /* Tabel */
    .kg-panel { border-radius: 1.25rem; overflow: hidden; background: var(--bs-body-bg); border: 1px solid var(--bs-border-color); box-shadow: 0 4px 16px rgba(0,0,0,.05); }
    .kg-panel thead th { padding-block: 1rem; font-size: .72rem; letter-spacing: .06em; text-transform: uppercase; color: var(--bs-secondary-color); background: var(--bs-tertiary-bg); border-bottom: 1px solid var(--bs-border-color); }
    .kg-panel tbody td { padding-block: .85rem; }

    .kg-dot {
        width: 38px; height: 38px; flex-shrink: 0; border-radius: .85rem;
        display: flex; align-items: center; justify-content: center;
        color: #fff; background: linear-gradient(135deg, #3d8bfd, #0a58ca);
    }
    .kg-dot.lg { width: 50px; height: 50px; font-size: 1.25rem; border-radius: 1rem; box-shadow: 0 8px 18px rgba(13,110,253,.28); }

    /* Kartu mobile */
    .kg-card {
        padding: 1.1rem; border-radius: 1.25rem;
        background: var(--bs-body-bg); border: 1px solid var(--bs-border-color);
        box-shadow: 0 2px 10px rgba(0,0,0,.05); transition: transform .25s, box-shadow .25s;
    }
    .kg-card:hover { transform: translateY(-3px); box-shadow: 0 14px 28px rgba(13,110,253,.12); }

    /* Kosong */
    .kg-empty { padding: 3rem 1rem; border-radius: 1.25rem; background: var(--bs-body-bg); border: 2px dashed var(--bs-border-color); }
    .kg-empty-icon { width: 76px; height: 76px; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; border-radius: 50%; color: var(--bs-primary); background: var(--bs-primary-bg-subtle); }

    @media (prefers-reduced-motion: reduce) {
        .kg-card { transition: none; }
        .kg-card:hover { transform: none; }
    }
</style>

<script>
    (function () {
        var search = document.getElementById('kgSearch');
        var items = document.querySelectorAll('.kg-item');
        var empty = document.getElementById('kgEmpty');
        var hadData = {{ count($list) ? 'true' : 'false' }};

        search.addEventListener('input', function () {
            var q = (search.value || '').toLowerCase().trim();
            var shown = 0;

            items.forEach(function (el) {
                var show = !q || el.dataset.search.indexOf(q) !== -1;
                el.classList.toggle('d-none', !show);
                if (show) shown++;
            });

            // Pesan "tidak ada hasil" hanya jika ada data tapi hasil pencarian nol
            if (hadData) {
                empty.classList.toggle('d-none', shown !== 0);
                if (shown === 0) {
                    document.getElementById('kgEmptyTitle').textContent = 'Tidak ada hasil';
                    document.getElementById('kgEmptyText').textContent = 'Coba kata kunci yang lain.';
                    document.getElementById('kgEmptyBtn').classList.add('d-none');
                }
            }
        });
    })();
</script>
@endsection