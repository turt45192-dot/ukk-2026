@extends('layouts.app')

@section('title', 'Daftar Alat & Fasilitas')

@section('content')
@php
    $currentUser = class_exists('\App\Models\User') && method_exists('\App\Models\User', 'current')
        ? \App\Models\User::current()
        : auth()->user();

    // Cek apakah user berhak menambah/mengedit data (bukan siswa)
    $canManage = $currentUser && isset($currentUser->role) && $currentUser->role !== 'siswa';

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

    // Tentukan jenis kondisi: baik / ringan / rusak
    $kondisiKey = function ($kondisi) {
        $k = strtolower((string) $kondisi);
        if (strpos($k, 'baik') !== false)   { return 'baik'; }
        if (strpos($k, 'ringan') !== false) { return 'ringan'; }
        return 'rusak';
    };
    $kondisiMeta = [
        'baik'   => ['success', 'bi-check-circle-fill'],
        'ringan' => ['warning', 'bi-exclamation-triangle-fill'],
        'rusak'  => ['danger',  'bi-x-circle-fill'],
    ];

    // Hitung ringkasan & daftar kategori unik
    $totalUnit = 0; $cBaik = 0; $cPerhatian = 0; $kategoriList = [];
    foreach ($list as $row) {
        $totalUnit += (int) ($row->jumlah ?? 0);
        if ($kondisiKey($row->kondisi) === 'baik') { $cBaik++; } else { $cPerhatian++; }
        $nk = trim((string) ($row->kategori->nama_kategori ?? ''));
        if ($nk !== '') { $kategoriList[strtolower($nk)] = $nk; }
    }
    ksort($kategoriList);
@endphp

<div class="container-fluid px-0 py-3">

    {{-- ===== Header ===== --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h1 class="at-title mb-1"><i class="bi bi-tools text-primary me-2"></i>Daftar Alat &amp; Fasilitas</h1>
            <p class="text-body-secondary mb-0">Kelola dan pantau inventaris sarana prasarana sekolah.</p>
        </div>
        @if($canManage)
            <a href="{{ route('alat.create') }}" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
                <i class="bi bi-plus-circle-fill"></i> Tambah Alat
            </a>
        @endif
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

    {{-- ===== Ringkasan ===== --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="at-stat">
                <div class="at-stat-icon bg-primary-subtle text-primary"><i class="bi bi-box-seam-fill"></i></div>
                <div><div class="at-stat-num">{{ $total }}</div><small class="text-body-secondary">Jenis Alat</small></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="at-stat">
                <div class="at-stat-icon bg-info-subtle text-info"><i class="bi bi-stack"></i></div>
                <div><div class="at-stat-num">{{ $totalUnit }}</div><small class="text-body-secondary">Total Unit</small></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="at-stat">
                <div class="at-stat-icon bg-success-subtle text-success"><i class="bi bi-check-circle-fill"></i></div>
                <div><div class="at-stat-num">{{ $cBaik }}</div><small class="text-body-secondary">Kondisi Baik</small></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="at-stat">
                <div class="at-stat-icon bg-warning-subtle text-warning"><i class="bi bi-exclamation-triangle-fill"></i></div>
                <div><div class="at-stat-num">{{ $cPerhatian }}</div><small class="text-body-secondary">Perlu Perhatian</small></div>
            </div>
        </div>
    </div>

    {{-- ===== Pencarian & filter ===== --}}
    <div class="at-toolbar mb-4">
        <div class="d-flex flex-column flex-md-row gap-2">
            <div class="input-group at-search flex-grow-1">
                <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-body-secondary"></i></span>
                <input type="search" id="atSearch" class="form-control border-start-0 ps-0" placeholder="Cari nama, kode, atau lokasi..." aria-label="Cari alat">
            </div>
            @if (count($kategoriList) > 1)
                <select id="atKategori" class="form-select at-select" aria-label="Filter kategori">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="at-chips" role="group" aria-label="Filter kondisi">
            <button type="button" class="at-chip active" data-kondisi="">Semua</button>
            <button type="button" class="at-chip" data-kondisi="baik"><i class="bi bi-check-circle-fill text-success me-1"></i>Baik</button>
            <button type="button" class="at-chip" data-kondisi="ringan"><i class="bi bi-exclamation-triangle-fill text-warning me-1"></i>Rusak Ringan</button>
            <button type="button" class="at-chip" data-kondisi="rusak"><i class="bi bi-x-circle-fill text-danger me-1"></i>Rusak Berat</button>
        </div>
    </div>

    {{-- ===== Tampilan TABEL (layar >= 992px) ===== --}}
    <div class="at-panel d-none d-lg-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:60px">No</th>
                        <th>Kategori</th>
                        <th style="min-width:170px">Nama Alat</th>
                        <th>Kode</th>
                        <th>Kondisi</th>
                        <th class="text-center">Jumlah</th>
                        <th style="min-width:150px">Lokasi</th>
                        @if($canManage)
                            <th class="text-end pe-4">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php $no = $startNo; @endphp
                    @foreach ($list as $d)
                        @php
                            $kk = $kondisiKey($d->kondisi);
                            $km = $kondisiMeta[$kk];
                            $katNama = $d->kategori->nama_kategori ?? '-';
                        @endphp
                        <tr class="at-item" data-kondisi="{{ $kk }}" data-kategori="{{ strtolower($katNama) }}"
                            data-search="{{ strtolower($d->nama_alat . ' ' . $d->kode_alat . ' ' . $d->lokasi) }}">
                            <td class="ps-4 text-body-secondary fw-semibold">{{ $no++ }}</td>
                            <td>
                                <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis border border-primary-subtle px-3 py-2 fw-medium">
                                    <i class="bi bi-tag-fill me-1"></i>{{ $katNama }}
                                </span>
                            </td>
                            <td class="fw-bold">{{ $d->nama_alat }}</td>
                            <td><code class="at-code">{{ $d->kode_alat }}</code></td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $km[0] }}-subtle text-{{ $km[0] }}-emphasis border border-{{ $km[0] }}-subtle px-3 py-2 fw-medium d-inline-flex align-items-center gap-1">
                                    <i class="bi {{ $km[1] }}"></i> {{ $d->kondisi }}
                                </span>
                            </td>
                            <td class="text-center"><span class="at-qty">{{ $d->jumlah }}</span></td>
                            <td class="text-body-secondary small">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $d->lokasi }}
                            </td>
                            @if($canManage)
                                <td class="text-end pe-4 text-nowrap">
                                    <a href="{{ route('alat.edit', ['alat' => $d->id_alat]) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3" title="Edit">
                                        <i class="bi bi-pencil-square"></i><span class="d-none d-xl-inline ms-1">Edit</span>
                                    </a>
                                    <form action="{{ route('alat.destroy', ['alat' => $d->id_alat]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus {{ addslashes($d->nama_alat) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Hapus">
                                            <i class="bi bi-trash3"></i><span class="d-none d-xl-inline ms-1">Hapus</span>
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== Tampilan KARTU (layar < 992px) ===== --}}
    <div class="row g-3 d-lg-none">
        @foreach ($list as $d)
            @php
                $kk = $kondisiKey($d->kondisi);
                $km = $kondisiMeta[$kk];
                $katNama = $d->kategori->nama_kategori ?? '-';
            @endphp
            <div class="col-12 col-md-6 at-item" data-kondisi="{{ $kk }}" data-kategori="{{ strtolower($katNama) }}"
                 data-search="{{ strtolower($d->nama_alat . ' ' . $d->kode_alat . ' ' . $d->lokasi) }}">
                <article class="at-card h-100">
                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                        <h2 class="h6 fw-bold mb-0 text-break">{{ $d->nama_alat }}</h2>
                        <span class="badge rounded-pill bg-{{ $km[0] }}-subtle text-{{ $km[0] }}-emphasis border border-{{ $km[0] }}-subtle d-inline-flex align-items-center gap-1 flex-shrink-0">
                            <i class="bi {{ $km[1] }}"></i> {{ $d->kondisi }}
                        </span>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis border border-primary-subtle">
                            <i class="bi bi-tag-fill me-1"></i>{{ $katNama }}
                        </span>
                        <code class="at-code">{{ $d->kode_alat }}</code>
                    </div>

                    <div class="at-meta">
                        <div><i class="bi bi-stack text-primary"></i> <span class="text-body-secondary">Jumlah</span> <strong>{{ $d->jumlah }} unit</strong></div>
                        <div class="min-w-0"><i class="bi bi-geo-alt-fill text-danger"></i> <span class="text-body-secondary">Lokasi</span> <strong class="text-break">{{ $d->lokasi }}</strong></div>
                    </div>

                    @if($canManage)
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('alat.edit', ['alat' => $d->id_alat]) }}" class="btn btn-outline-warning rounded-pill flex-fill fw-semibold">
                                <i class="bi bi-pencil-square me-1"></i>Edit
                            </a>
                            <form action="{{ route('alat.destroy', ['alat' => $d->id_alat]) }}" method="POST" class="flex-fill" onsubmit="return confirm('Yakin ingin menghapus {{ addslashes($d->nama_alat) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger rounded-pill w-100 fw-semibold">
                                    <i class="bi bi-trash3 me-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </article>
            </div>
        @endforeach
    </div>

    {{-- ===== Keadaan kosong ===== --}}
    <div id="atEmpty" class="at-empty text-center {{ count($list) ? 'd-none' : '' }}">
        <div class="at-empty-icon"><i class="bi bi-tools"></i></div>
        <h2 class="h5 fw-bold" id="atEmptyTitle">Belum ada data alat</h2>
        <p class="text-body-secondary mb-3" id="atEmptyText">Silakan tambahkan data alat inventaris baru.</p>
        @if($canManage)
            <a href="{{ route('alat.create') }}" class="btn btn-primary rounded-pill px-4" id="atEmptyBtn">
                <i class="bi bi-plus-circle-fill me-1"></i>Tambah Alat
            </a>
        @endif
    </div>

    {{-- ===== Pagination ===== --}}
    @if (is_object($data) && method_exists($data, 'hasPages') && $data->hasPages())
        <div class="mt-4 d-flex justify-content-end overflow-auto">{!! $data->links() !!}</div>
    @endif
</div>

<style>
    .min-w-0 { min-width: 0; }
    .at-title { font-size: clamp(1.4rem, 1.1rem + 1.4vw, 2rem); font-weight: 800; letter-spacing: -.01em; }

    /* Ringkasan */
    .at-stat {
        display: flex; align-items: center; gap: .85rem; padding: 1rem 1.1rem; height: 100%;
        border-radius: 1rem; background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color); box-shadow: 0 2px 10px rgba(0,0,0,.04);
    }
    .at-stat-icon { width: 44px; height: 44px; flex-shrink: 0; border-radius: .85rem; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .at-stat-num { font-size: 1.5rem; font-weight: 800; line-height: 1; }

    /* Toolbar */
    .at-toolbar { display: flex; flex-direction: column; gap: .85rem; }
    .at-search { max-width: 520px; }
    .at-search .input-group-text, .at-search .form-control { border-radius: 999px; padding-block: .6rem; }
    .at-search .input-group-text { border-top-right-radius: 0; border-bottom-right-radius: 0; padding-left: 1.1rem; }
    .at-search .form-control { border-top-left-radius: 0; border-bottom-left-radius: 0; }
    .at-select { border-radius: 999px; padding-block: .6rem; padding-inline: 1.1rem 2.25rem; }
    @media (min-width: 768px) { .at-select { max-width: 240px; } }
    .at-chips { display: flex; gap: .5rem; overflow-x: auto; padding-bottom: .25rem; scrollbar-width: none; }
    .at-chips::-webkit-scrollbar { display: none; }
    .at-chip {
        flex-shrink: 0; padding: .4rem 1rem; border-radius: 999px; font-size: .85rem; font-weight: 600; white-space: nowrap;
        color: var(--bs-body-color); background: var(--bs-body-bg); border: 1px solid var(--bs-border-color);
        transition: all .2s;
    }
    .at-chip:hover { border-color: var(--bs-primary); color: var(--bs-primary); }
    .at-chip.active { background: var(--bs-primary); border-color: var(--bs-primary); color: #fff; }
    .at-chip.active i { color: #fff !important; }

    /* Tabel */
    .at-panel { border-radius: 1.25rem; overflow: hidden; background: var(--bs-body-bg); border: 1px solid var(--bs-border-color); box-shadow: 0 4px 16px rgba(0,0,0,.05); }
    .at-panel thead th { padding-block: 1rem; font-size: .72rem; letter-spacing: .06em; text-transform: uppercase; color: var(--bs-secondary-color); background: var(--bs-tertiary-bg); border-bottom: 1px solid var(--bs-border-color); white-space: nowrap; }
    .at-panel tbody td { padding-block: .85rem; }
    .at-code { padding: .25rem .6rem; border-radius: .5rem; font-size: .8rem; color: var(--bs-primary); background: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color); }
    .at-qty { display: inline-block; min-width: 2.4rem; padding: .3rem .6rem; border-radius: .7rem; font-weight: 800; background: var(--bs-secondary-bg); }

    /* Kartu mobile */
    .at-card {
        display: flex; flex-direction: column; padding: 1.1rem; border-radius: 1.25rem;
        background: var(--bs-body-bg); border: 1px solid var(--bs-border-color);
        box-shadow: 0 2px 10px rgba(0,0,0,.05); transition: transform .25s, box-shadow .25s;
    }
    .at-card:hover { transform: translateY(-3px); box-shadow: 0 14px 28px rgba(13,110,253,.12); }
    .at-meta { display: flex; flex-direction: column; gap: .4rem; padding: .75rem .9rem; border-radius: .85rem; font-size: .875rem; background: var(--bs-tertiary-bg); }
    .at-meta i { margin-right: .25rem; }
    .at-meta strong { margin-left: .25rem; }

    /* Kosong */
    .at-empty { padding: 3rem 1rem; border-radius: 1.25rem; background: var(--bs-body-bg); border: 2px dashed var(--bs-border-color); }
    .at-empty-icon { width: 76px; height: 76px; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; border-radius: 50%; color: var(--bs-primary); background: var(--bs-primary-bg-subtle); }

    @media (prefers-reduced-motion: reduce) {
        .at-card, .at-chip { transition: none; }
        .at-card:hover { transform: none; }
    }
</style>

<script>
    (function () {
        var search = document.getElementById('atSearch');
        var kategori = document.getElementById('atKategori');
        var chips = document.querySelectorAll('.at-chip');
        var items = document.querySelectorAll('.at-item');
        var empty = document.getElementById('atEmpty');
        var hadData = {{ count($list) ? 'true' : 'false' }};
        var activeKondisi = '';

        function apply() {
            var q = (search.value || '').toLowerCase().trim();
            var kat = kategori ? kategori.value : '';
            var shown = 0;

            items.forEach(function (el) {
                var show = (!activeKondisi || el.dataset.kondisi === activeKondisi) &&
                           (!kat || el.dataset.kategori === kat) &&
                           (!q || el.dataset.search.indexOf(q) !== -1);
                el.classList.toggle('d-none', !show);
                if (show) shown++;
            });

            // Pesan "tidak ada hasil" hanya jika ada data tapi hasil filter nol
            if (hadData) {
                empty.classList.toggle('d-none', shown !== 0);
                if (shown === 0) {
                    document.getElementById('atEmptyTitle').textContent = 'Tidak ada hasil';
                    document.getElementById('atEmptyText').textContent = 'Coba kata kunci atau filter yang lain.';
                    var b = document.getElementById('atEmptyBtn');
                    if (b) b.classList.add('d-none');
                }
            }
        }

        search.addEventListener('input', apply);
        if (kategori) kategori.addEventListener('change', apply);
        chips.forEach(function (chip) {
            chip.addEventListener('click', function () {
                chips.forEach(function (c) { c.classList.remove('active'); });
                chip.classList.add('active');
                activeKondisi = chip.dataset.kondisi;
                apply();
            });
        });
    })();
</script>
@endsection