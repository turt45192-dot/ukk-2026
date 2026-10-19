@extends('layouts.app')

@section('title', 'Pengguna')

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

    // Daftar kelas unik untuk filter
    $kelasList = [];
    foreach ($list as $row) {
        $k = trim((string) ($row->kelas ?? ''));
        if ($k !== '') { $kelasList[strtolower($k)] = $k; }
    }
    ksort($kelasList);

    // Inisial untuk avatar
    $initial = function ($nama) {
        $nama = trim((string) $nama);
        if ($nama === '') { return '?'; }
        return function_exists('mb_substr') ? mb_strtoupper(mb_substr($nama, 0, 1)) : strtoupper(substr($nama, 0, 1));
    };
@endphp

<div class="container-fluid px-0 py-3">

    {{-- ===== Header ===== --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h1 class="pu-title mb-1"><i class="bi bi-people-fill text-primary me-2"></i>Pengguna</h1>
            <p class="text-body-secondary mb-0">Kelola data siswa yang terdaftar di sistem.</p>
        </div>
        <a href="{{ route('pengguna.create') }}" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
            <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
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

    {{-- ===== Ringkasan ===== --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="pu-stat">
                <div class="pu-stat-icon bg-primary-subtle text-primary"><i class="bi bi-people-fill"></i></div>
                <div><div class="pu-stat-num">{{ $total }}</div><small class="text-body-secondary">Total Pengguna</small></div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="pu-stat">
                <div class="pu-stat-icon bg-success-subtle text-success"><i class="bi bi-mortarboard-fill"></i></div>
                <div><div class="pu-stat-num">{{ count($kelasList) }}</div><small class="text-body-secondary">Kelas</small></div>
            </div>
        </div>
    </div>

    {{-- ===== Pencarian & filter ===== --}}
    <div class="pu-toolbar mb-4">
        <div class="input-group pu-search">
            <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-body-secondary"></i></span>
            <input type="search" id="puSearch" class="form-control border-start-0 ps-0" placeholder="Cari nama, NIS, atau kelas..." aria-label="Cari pengguna">
        </div>
        @if (count($kelasList) > 1)
            <div class="pu-chips" role="group" aria-label="Filter kelas">
                <button type="button" class="pu-chip active" data-kelas="">Semua</button>
                @foreach ($kelasList as $key => $label)
                    <button type="button" class="pu-chip" data-kelas="{{ $key }}">{{ $label }}</button>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ===== Tampilan TABEL (layar >= 992px) ===== --}}
    <div class="pu-panel d-none d-lg-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:64px">No</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = $startNo; @endphp
                    @foreach ($list as $d)
                        <tr class="pu-item" data-kelas="{{ strtolower((string) $d->kelas) }}"
                            data-search="{{ strtolower($d->nama . ' ' . $d->nis . ' ' . $d->kelas) }}">
                            <td class="ps-4 text-body-secondary fw-semibold">{{ $no++ }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="pu-avatar">{{ $initial($d->nama) }}</div>
                                    <span class="fw-bold">{{ $d->nama }}</span>
                                </div>
                            </td>
                            <td><code class="pu-code">{{ $d->nis }}</code></td>
                            <td>
                                <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis border border-primary-subtle px-3 py-2">{{ $d->kelas }}</span>
                            </td>
                            <td class="text-end pe-4 text-nowrap">
                                <a href="{{ route('pengguna.edit', ['pengguna' => $d->id_siswa]) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('pengguna.destroy', ['pengguna' => $d->id_siswa]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau hapus {{ addslashes($d->nama) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
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

    {{-- ===== Tampilan KARTU (layar < 992px) ===== --}}
    <div class="row g-3 d-lg-none">
        @foreach ($list as $d)
            <div class="col-12 col-md-6 pu-item" data-kelas="{{ strtolower((string) $d->kelas) }}"
                 data-search="{{ strtolower($d->nama . ' ' . $d->nis . ' ' . $d->kelas) }}">
                <article class="pu-card h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="pu-avatar lg">{{ $initial($d->nama) }}</div>
                        <div class="min-w-0">
                            <h2 class="h6 fw-bold mb-1 text-truncate">{{ $d->nama }}</h2>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis border border-primary-subtle">
                                    <i class="bi bi-mortarboard me-1"></i>{{ $d->kelas }}
                                </span>
                                <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle">
                                    <i class="bi bi-card-heading me-1"></i>{{ $d->nis }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-auto">
                        <a href="{{ route('pengguna.edit', ['pengguna' => $d->id_siswa]) }}" class="btn btn-outline-warning rounded-pill flex-fill fw-semibold">
                            <i class="bi bi-pencil-square me-1"></i>Edit
                        </a>
                        <form action="{{ route('pengguna.destroy', ['pengguna' => $d->id_siswa]) }}" method="POST" class="flex-fill" onsubmit="return confirm('Yakin mau hapus {{ addslashes($d->nama) }}?')">
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
    <div id="puEmpty" class="pu-empty text-center {{ count($list) ? 'd-none' : '' }}">
        <div class="pu-empty-icon"><i class="bi bi-people"></i></div>
        <h2 class="h5 fw-bold" id="puEmptyTitle">Belum ada pengguna</h2>
        <p class="text-body-secondary mb-3" id="puEmptyText">Mulai dengan menambahkan pengguna pertama.</p>
        <a href="{{ route('pengguna.create') }}" class="btn btn-primary rounded-pill px-4" id="puEmptyBtn">
            <i class="bi bi-person-plus-fill me-1"></i>Tambah Pengguna
        </a>
    </div>

    {{-- ===== Pagination ===== --}}
    @if (is_object($data) && method_exists($data, 'links'))
        <div class="mt-4 d-flex justify-content-start overflow-auto">{!! $data->links() !!}</div>
    @endif
</div>

<style>
    .min-w-0 { min-width: 0; }
    .pu-title { font-size: clamp(1.4rem, 1.1rem + 1.4vw, 2rem); font-weight: 800; letter-spacing: -.01em; }

    /* Ringkasan */
    .pu-stat {
        display: flex; align-items: center; gap: .85rem; padding: 1rem 1.1rem;
        border-radius: 1rem; background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color); box-shadow: 0 2px 10px rgba(0,0,0,.04);
    }
    .pu-stat-icon { width: 44px; height: 44px; flex-shrink: 0; border-radius: .85rem; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .pu-stat-num { font-size: 1.5rem; font-weight: 800; line-height: 1; }

    /* Toolbar */
    .pu-toolbar { display: flex; flex-direction: column; gap: .85rem; }
    .pu-search { max-width: 520px; }
    .pu-search .input-group-text, .pu-search .form-control { border-radius: 999px; padding-block: .6rem; }
    .pu-search .input-group-text { border-top-right-radius: 0; border-bottom-right-radius: 0; padding-left: 1.1rem; }
    .pu-search .form-control { border-top-left-radius: 0; border-bottom-left-radius: 0; }
    .pu-chips { display: flex; gap: .5rem; overflow-x: auto; padding-bottom: .25rem; scrollbar-width: none; }
    .pu-chips::-webkit-scrollbar { display: none; }
    .pu-chip {
        flex-shrink: 0; padding: .4rem 1rem; border-radius: 999px; font-size: .85rem; font-weight: 600;
        color: var(--bs-body-color); background: var(--bs-body-bg); border: 1px solid var(--bs-border-color);
        transition: all .2s;
    }
    .pu-chip:hover { border-color: var(--bs-primary); color: var(--bs-primary); }
    .pu-chip.active { background: var(--bs-primary); border-color: var(--bs-primary); color: #fff; }

    /* Tabel */
    .pu-panel { border-radius: 1.25rem; overflow: hidden; background: var(--bs-body-bg); border: 1px solid var(--bs-border-color); box-shadow: 0 4px 16px rgba(0,0,0,.05); }
    .pu-panel thead th { padding-block: 1rem; font-size: .72rem; letter-spacing: .06em; text-transform: uppercase; color: var(--bs-secondary-color); background: var(--bs-tertiary-bg); border-bottom: 1px solid var(--bs-border-color); }
    .pu-panel tbody td { padding-block: .85rem; }
    .pu-code { padding: .25rem .6rem; border-radius: .5rem; color: var(--bs-body-color); background: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color); }

    /* Avatar */
    .pu-avatar {
        width: 40px; height: 40px; flex-shrink: 0; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: #fff; background: linear-gradient(135deg, #3d8bfd, #0a58ca);
    }
    .pu-avatar.lg { width: 52px; height: 52px; font-size: 1.3rem; box-shadow: 0 8px 18px rgba(13,110,253,.28); }

    /* Kartu mobile */
    .pu-card {
        display: flex; flex-direction: column; padding: 1.1rem; border-radius: 1.25rem;
        background: var(--bs-body-bg); border: 1px solid var(--bs-border-color);
        box-shadow: 0 2px 10px rgba(0,0,0,.05); transition: transform .25s, box-shadow .25s;
    }
    .pu-card:hover { transform: translateY(-3px); box-shadow: 0 14px 28px rgba(13,110,253,.12); }

    /* Kosong */
    .pu-empty { padding: 3rem 1rem; border-radius: 1.25rem; background: var(--bs-body-bg); border: 2px dashed var(--bs-border-color); }
    .pu-empty-icon { width: 76px; height: 76px; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; border-radius: 50%; color: var(--bs-primary); background: var(--bs-primary-bg-subtle); }

    @media (prefers-reduced-motion: reduce) {
        .pu-card, .pu-chip { transition: none; }
        .pu-card:hover { transform: none; }
    }
</style>

<script>
    (function () {
        var search = document.getElementById('puSearch');
        var chips = document.querySelectorAll('.pu-chip');
        var items = document.querySelectorAll('.pu-item');
        var empty = document.getElementById('puEmpty');
        var hadData = {{ count($list) ? 'true' : 'false' }};
        var activeKelas = '';

        function apply() {
            var q = (search.value || '').toLowerCase().trim();
            var shown = 0;

            items.forEach(function (el) {
                var show = (!activeKelas || el.dataset.kelas === activeKelas) &&
                           (!q || el.dataset.search.indexOf(q) !== -1);
                el.classList.toggle('d-none', !show);
                if (show) shown++;
            });

            // Pesan "tidak ada hasil" hanya jika ada data tapi hasil filter nol
            if (hadData) {
                empty.classList.toggle('d-none', shown !== 0);
                if (shown === 0) {
                    document.getElementById('puEmptyTitle').textContent = 'Tidak ada hasil';
                    document.getElementById('puEmptyText').textContent = 'Coba kata kunci atau filter kelas yang lain.';
                    document.getElementById('puEmptyBtn').classList.add('d-none');
                }
            }
        }

        search.addEventListener('input', apply);
        chips.forEach(function (chip) {
            chip.addEventListener('click', function () {
                chips.forEach(function (c) { c.classList.remove('active'); });
                chip.classList.add('active');
                activeKelas = chip.dataset.kelas;
                apply();
            });
        });
    })();
</script>
@endsection