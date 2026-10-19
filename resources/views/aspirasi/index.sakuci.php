@extends('layouts.app')

@section('title', 'Daftar Aspirasi')

@section('content')
@php
    // Ubah $data menjadi array biasa (framework ini tidak punya helper collect())
    $list = [];
    if (is_array($data ?? null)) {
        $list = array_values($data);
    } elseif (is_iterable($data ?? null)) {
        foreach ($data as $row) { $list[] = $row; }
    }

    // Warna badge sesuai status
    $statusClass = function ($status) {
        $map = [
            'selesai' => 'success', 'diterima' => 'success', 'disetujui' => 'success',
            'proses' => 'info', 'diproses' => 'info', 'dikerjakan' => 'info',
            'ditolak' => 'danger', 'batal' => 'danger',
            'menunggu' => 'warning', 'pending' => 'warning', 'baru' => 'warning', '' => 'warning',
        ];
        $key = strtolower(trim((string) $status));
        return $map[$key] ?? 'secondary';
    };

    // Hitung jumlah per status
    $statuses = [];
    $statusCounts = [];
    foreach ($list as $row) {
        $label = trim((string) ($row->status ?? ''));
        if ($label === '') { continue; }
        $key = strtolower($label);
        if (!isset($statusCounts[$key])) { $statuses[$key] = $label; $statusCounts[$key] = 0; }
        $statusCounts[$key]++;
    }
@endphp

<div class="container-fluid px-0 py-3">

    {{-- ===== Header ===== --}}
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h1 class="ap-title mb-1"><i class="bi bi-chat-left-text-fill text-primary me-2"></i>Daftar Aspirasi</h1>
            <p class="text-body-secondary mb-0">Kelola laporan dan masukan terkait sarana &amp; prasarana sekolah.</p>
        </div>
        <a href="{{ route('aspirasi.create') }}" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
            <i class="bi bi-plus-lg"></i> Tambah Aspirasi
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

    {{-- ===== Ringkasan ===== --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="ap-stat">
                <div class="ap-stat-icon bg-primary-subtle text-primary"><i class="bi bi-inboxes-fill"></i></div>
                <div><div class="ap-stat-num">{{ count($list) }}</div><small class="text-body-secondary">Total</small></div>
            </div>
        </div>
        @foreach (array_slice($statuses, 0, 3, true) as $key => $st)
            @php $c = $statusClass($st); @endphp
            <div class="col-6 col-lg-3">
                <div class="ap-stat">
                    <div class="ap-stat-icon bg-{{ $c }}-subtle text-{{ $c }}"><i class="bi bi-circle-fill" style="font-size:.6rem"></i></div>
                    <div>
                        <div class="ap-stat-num">{{ $statusCounts[$key] }}</div>
                        <small class="text-body-secondary text-capitalize">{{ $st }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ===== Pencarian & filter ===== --}}
    <div class="ap-toolbar mb-4">
        <div class="input-group ap-search">
            <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-body-secondary"></i></span>
            <input type="search" id="apSearch" class="form-control border-start-0 ps-0" placeholder="Cari judul, kategori, atau deskripsi..." aria-label="Cari aspirasi">
        </div>
        <div class="ap-chips" role="group" aria-label="Filter status">
            <button type="button" class="ap-chip active" data-status="">Semua</button>
            @foreach ($statuses as $key => $st)
                <button type="button" class="ap-chip text-capitalize" data-status="{{ $key }}">{{ $st }}</button>
            @endforeach
        </div>
    </div>

    {{-- ===== Tampilan TABEL (layar >= 992px) ===== --}}
    <div class="ap-panel d-none d-lg-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:56px">No</th>
                        <th style="width:96px">Foto</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th style="min-width:240px">Deskripsi</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $index => $item)
                        <tr class="ap-item" data-status="{{ strtolower($item->status) }}"
                            data-search="{{ strtolower($item->judul . ' ' . ($item->kategori->nama_kategori ?? '') . ' ' . $item->deskripsi) }}">
                            <td class="ps-4 text-body-secondary fw-semibold">{{ $index + 1 }}</td>
                            <td>
                                @if($item->foto)
                                    <img src="{{ asset('uploads/aspirasi/' . $item->foto) }}" alt="Foto {{ $item->judul }}"
                                         class="ap-thumb" loading="lazy" role="button"
                                         data-bs-toggle="modal" data-bs-target="#apPhotoModal"
                                         data-src="{{ asset('uploads/aspirasi/' . $item->foto) }}" data-title="{{ $item->judul }}">
                                @else
                                    <div class="ap-thumb ap-thumb-empty"><i class="bi bi-image"></i></div>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $item->judul }}</td>
                            <td>
                                <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis border border-primary-subtle">
                                    {{ $item->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="text-body-secondary small"><div class="ap-clamp">{{ $item->deskripsi }}</div></td>
                            <td>
                                @php $c = $statusClass($item->status); @endphp
                                <span class="badge rounded-pill bg-{{ $c }}-subtle text-{{ $c }}-emphasis border border-{{ $c }}-subtle px-3 py-2 text-capitalize">{{ $item->status ?: 'Menunggu' }}</span>
                            </td>
                            <td class="text-end pe-4 text-nowrap">
                                <a href="{{ route('aspirasi.edit', ['id_aspirasi' => $item->id_aspirasi]) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3" title="Edit">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('aspirasi.destroy', ['id_aspirasi' => $item->id_aspirasi]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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

    {{-- ===== Tampilan KARTU (layar < 992px) ===== --}}
    <div class="row g-3 d-lg-none">
        @foreach($list as $item)
            @php $c = $statusClass($item->status); @endphp
            <div class="col-12 col-md-6 ap-item" data-status="{{ strtolower($item->status) }}"
                 data-search="{{ strtolower($item->judul . ' ' . ($item->kategori->nama_kategori ?? '') . ' ' . $item->deskripsi) }}">
                <article class="ap-card h-100">
                    <div class="d-flex gap-3">
                        @if($item->foto)
                            <img src="{{ asset('uploads/aspirasi/' . $item->foto) }}" alt="Foto {{ $item->judul }}"
                                 class="ap-thumb lg flex-shrink-0" loading="lazy" role="button"
                                 data-bs-toggle="modal" data-bs-target="#apPhotoModal"
                                 data-src="{{ asset('uploads/aspirasi/' . $item->foto) }}" data-title="{{ $item->judul }}">
                        @else
                            <div class="ap-thumb lg ap-thumb-empty flex-shrink-0"><i class="bi bi-image"></i></div>
                        @endif
                        <div class="min-w-0 flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                <h2 class="h6 fw-bold mb-0 text-break">{{ $item->judul }}</h2>
                                <span class="badge rounded-pill bg-{{ $c }}-subtle text-{{ $c }}-emphasis border border-{{ $c }}-subtle text-capitalize flex-shrink-0">{{ $item->status ?: 'Menunggu' }}</span>
                            </div>
                            <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis border border-primary-subtle mb-2">
                                <i class="bi bi-tag-fill me-1"></i>{{ $item->kategori->nama_kategori ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <p class="text-body-secondary small my-3 ap-clamp">{{ $item->deskripsi }}</p>

                    <div class="d-flex gap-2 mt-auto">
                        <a href="{{ route('aspirasi.edit', ['id_aspirasi' => $item->id_aspirasi]) }}" class="btn btn-outline-warning rounded-pill flex-fill fw-semibold">
                            <i class="bi bi-pencil-square me-1"></i>Edit
                        </a>
                        <form action="{{ route('aspirasi.destroy', ['id_aspirasi' => $item->id_aspirasi]) }}" method="POST" class="flex-fill" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
    <div id="apEmpty" class="ap-empty text-center {{ count($list) ? 'd-none' : '' }}">
        <div class="ap-empty-icon"><i class="bi bi-chat-square-dots"></i></div>
        <h2 class="h5 fw-bold" id="apEmptyTitle">Belum ada data aspirasi</h2>
        <p class="text-body-secondary mb-3" id="apEmptyText">Mulai dengan menambahkan aspirasi pertama.</p>
        <a href="{{ route('aspirasi.create') }}" class="btn btn-primary rounded-pill px-4" id="apEmptyBtn">
            <i class="bi bi-plus-lg me-1"></i>Tambah Aspirasi
        </a>
    </div>

</div>

{{-- ===== Modal pratinjau foto ===== --}}
<div class="modal fade" id="apPhotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 overflow-hidden">
            <div class="modal-header border-0 pb-0">
                <h2 class="modal-title h6 fw-bold" id="apPhotoTitle">Foto</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center">
                <img id="apPhotoImg" src="" alt="" class="img-fluid rounded-3" style="max-height: 70vh;">
            </div>
        </div>
    </div>
</div>

<style>
    .min-w-0 { min-width: 0; }
    .ap-title { font-size: clamp(1.4rem, 1.1rem + 1.4vw, 2rem); font-weight: 800; letter-spacing: -.01em; }

    /* Ringkasan */
    .ap-stat {
        display: flex; align-items: center; gap: .85rem; padding: 1rem 1.1rem;
        border-radius: 1rem; background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color); box-shadow: 0 2px 10px rgba(0,0,0,.04);
    }
    .ap-stat-icon { width: 44px; height: 44px; flex-shrink: 0; border-radius: .85rem; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .ap-stat-num { font-size: 1.5rem; font-weight: 800; line-height: 1; }

    /* Toolbar */
    .ap-toolbar { display: flex; flex-direction: column; gap: .85rem; }
    .ap-search { max-width: 520px; }
    .ap-search .input-group-text, .ap-search .form-control { border-radius: 999px; padding-block: .6rem; }
    .ap-search .input-group-text { border-top-right-radius: 0; border-bottom-right-radius: 0; padding-left: 1.1rem; }
    .ap-search .form-control { border-top-left-radius: 0; border-bottom-left-radius: 0; }
    .ap-chips { display: flex; gap: .5rem; overflow-x: auto; padding-bottom: .25rem; scrollbar-width: none; }
    .ap-chips::-webkit-scrollbar { display: none; }
    .ap-chip {
        flex-shrink: 0; padding: .4rem 1rem; border-radius: 999px; font-size: .85rem; font-weight: 600;
        color: var(--bs-body-color); background: var(--bs-body-bg); border: 1px solid var(--bs-border-color);
        transition: all .2s;
    }
    .ap-chip:hover { border-color: var(--bs-primary); color: var(--bs-primary); }
    .ap-chip.active { background: var(--bs-primary); border-color: var(--bs-primary); color: #fff; }

    /* Tabel */
    .ap-panel { border-radius: 1.25rem; overflow: hidden; background: var(--bs-body-bg); border: 1px solid var(--bs-border-color); box-shadow: 0 4px 16px rgba(0,0,0,.05); }
    .ap-panel thead th { padding-block: 1rem; font-size: .72rem; letter-spacing: .06em; text-transform: uppercase; color: var(--bs-secondary-color); background: var(--bs-tertiary-bg); border-bottom: 1px solid var(--bs-border-color); }
    .ap-panel tbody td { padding-block: .9rem; }
    .ap-panel tbody tr { transition: background-color .15s; }

    /* Foto */
    .ap-thumb { width: 64px; height: 64px; object-fit: cover; border-radius: .85rem; border: 1px solid var(--bs-border-color); transition: transform .2s; }
    .ap-thumb.lg { width: 76px; height: 76px; }
    img.ap-thumb:hover { transform: scale(1.06); }
    .ap-thumb-empty { display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: var(--bs-secondary-color); background: var(--bs-tertiary-bg); }

    /* Deskripsi dipotong 2 baris */
    .ap-clamp { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    /* Kartu mobile */
    .ap-card {
        display: flex; flex-direction: column; padding: 1.1rem; border-radius: 1.25rem;
        background: var(--bs-body-bg); border: 1px solid var(--bs-border-color);
        box-shadow: 0 2px 10px rgba(0,0,0,.05); transition: transform .25s, box-shadow .25s;
    }
    .ap-card:hover { transform: translateY(-3px); box-shadow: 0 14px 28px rgba(13,110,253,.12); }

    /* Kosong */
    .ap-empty { padding: 3rem 1rem; border-radius: 1.25rem; background: var(--bs-body-bg); border: 2px dashed var(--bs-border-color); }
    .ap-empty-icon { width: 76px; height: 76px; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; border-radius: 50%; color: var(--bs-primary); background: var(--bs-primary-bg-subtle); }

    @media (prefers-reduced-motion: reduce) {
        .ap-card, .ap-thumb, .ap-chip { transition: none; }
        .ap-card:hover, img.ap-thumb:hover { transform: none; }
    }
</style>

<script>
    (function () {
        var search = document.getElementById('apSearch');
        var chips = document.querySelectorAll('.ap-chip');
        var items = document.querySelectorAll('.ap-item');
        var empty = document.getElementById('apEmpty');
        var hadData = {{ count($list) ? 'true' : 'false' }};
        var activeStatus = '';

        function apply() {
            var q = (search.value || '').toLowerCase().trim();
            var visible = new Set();

            items.forEach(function (el) {
                var okStatus = !activeStatus || el.dataset.status === activeStatus;
                var okText = !q || el.dataset.search.indexOf(q) !== -1;
                var show = okStatus && okText;
                el.classList.toggle('d-none', !show);
                if (show) visible.add(el);
            });

            // Pesan kosong hanya jika ada data tapi hasil filter nol
            if (hadData) {
                var none = visible.size === 0;
                empty.classList.toggle('d-none', !none);
                if (none) {
                    document.getElementById('apEmptyTitle').textContent = 'Tidak ada hasil';
                    document.getElementById('apEmptyText').textContent = 'Coba kata kunci atau filter status yang lain.';
                    document.getElementById('apEmptyBtn').classList.add('d-none');
                }
            }
        }

        search.addEventListener('input', apply);
        chips.forEach(function (chip) {
            chip.addEventListener('click', function () {
                chips.forEach(function (c) { c.classList.remove('active'); });
                chip.classList.add('active');
                activeStatus = chip.dataset.status;
                apply();
            });
        });

        // Modal foto
        var modal = document.getElementById('apPhotoModal');
        modal.addEventListener('show.bs.modal', function (e) {
            var t = e.relatedTarget;
            if (!t) return;
            document.getElementById('apPhotoImg').src = t.dataset.src;
            document.getElementById('apPhotoImg').alt = t.dataset.title;
            document.getElementById('apPhotoTitle').textContent = t.dataset.title;
        });
    })();
</script>
@endsection