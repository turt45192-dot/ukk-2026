@extends('layouts.app')

@section('title', config('app.name') . ' - Sistem Sarana & Prasarana')

@section('content')
@php
    $currentUser = \App\Models\User::current();
    $isAdmin = $currentUser && isset($currentUser->role) && $currentUser->role === 'admin';
    $ctaUrl = $currentUser
        ? ($isAdmin ? route('admin.dashboard') : route('dashboard'))
        : route('login');
    $ctaLabel = $currentUser ? 'Buka Dashboard' : 'Masuk ke Sistem';
@endphp

{{-- ===================== HERO ===================== --}}
<section class="wl-hero position-relative overflow-hidden">
    <div class="wl-orb wl-orb-1" aria-hidden="true"></div>
    <div class="wl-orb wl-orb-2" aria-hidden="true"></div>

    <div class="container position-relative py-5" style="z-index: 2;">
        <div class="row align-items-center g-5 py-lg-4">

            {{-- Kiri: teks & aksi --}}
            <div class="col-xl-7 text-center text-xl-start">
                <span class="wl-pill wl-reveal">
                    <i class="bi bi-fire"></i> SAKUCI ONE FIRE
                </span>

                {{-- Logo brand (warna teks mengikuti tema) --}}
                <div class="my-4 wl-reveal" style="--d: .05s;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 330 120" role="img" aria-label="Logo Sarpras Sakuci" class="wl-logo">
                        <defs>
                            <linearGradient id="wlBlue" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#3d8bfd"/>
                                <stop offset="100%" stop-color="#0a58ca"/>
                            </linearGradient>
                            <filter id="wlGlow" x="-20%" y="-20%" width="140%" height="140%">
                                <feDropShadow dx="0" dy="4" stdDeviation="6" flood-color="#0d6efd" flood-opacity="0.3"/>
                            </filter>
                        </defs>
                        <g filter="url(#wlGlow)">
                            <rect x="10" y="10" width="100" height="100" rx="28" fill="url(#wlBlue)"/>
                            <path d="M35 82 V48 L60 30 L85 48 V82 Z" fill="none" stroke="#fff" stroke-width="6" stroke-linejoin="round"/>
                            <rect x="48" y="55" width="24" height="27" rx="4" fill="#0242a0" stroke="#fff" stroke-width="2"/>
                            <circle cx="60" cy="42" r="4" fill="#fff"/>
                        </g>
                        <text x="130" y="62" font-family="'Plus Jakarta Sans','Segoe UI',sans-serif" font-weight="900" font-size="40" fill="#0d6efd" letter-spacing="2">SARPRAS</text>
                        <text x="130" y="96" font-family="'Plus Jakarta Sans','Segoe UI',sans-serif" font-weight="800" font-size="28" fill="currentColor" letter-spacing="4">SAKUCI</text>
                    </svg>
                </div>

                <h1 class="wl-title mb-4 wl-reveal" style="--d: .1s;">
                    Pusat Kendali &amp; Layanan
                    <span class="wl-gradient-text d-block">Sarana Prasarana Sekolah</span>
                </h1>

                <p class="wl-lead text-body-secondary mx-auto mx-xl-0 mb-4 wl-reveal" style="--d: .15s;">
                    Sistem informasi digital SMK Sangkuriang 1 Cimahi untuk mengelola inventaris alat,
                    memetakan prasarana, dan menjaga transparansi fasilitas sekolah secara real-time.
                </p>

                <div class="d-flex flex-column flex-sm-row flex-wrap gap-3 justify-content-center justify-content-xl-start mb-4 wl-reveal" style="--d: .2s;">
                    <a href="{{ $ctaUrl }}" class="btn wl-btn-primary btn-lg rounded-pill px-4 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                        <i class="bi {{ $currentUser ? 'bi-speedometer2' : 'bi-box-arrow-in-right' }}"></i>
                        <span>{{ $ctaLabel }}</span>
                    </a>
                    <a href="#ringkasan" class="btn btn-outline-secondary btn-lg rounded-pill px-4 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-bar-chart-line text-primary"></i>
                        <span>Lihat Ringkasan</span>
                    </a>
                </div>

                <ul class="list-unstyled d-flex flex-wrap gap-3 gap-md-4 justify-content-center justify-content-xl-start text-body-secondary small fw-semibold mb-0 wl-reveal" style="--d: .25s;">
                    <li><i class="bi bi-check-circle-fill text-success me-1"></i>Real-time</li>
                    <li><i class="bi bi-check-circle-fill text-success me-1"></i>Multi-role</li>
                    <li><i class="bi bi-check-circle-fill text-success me-1"></i>Terang &amp; Gelap</li>
                    <li><i class="bi bi-check-circle-fill text-success me-1"></i>Semua perangkat</li>
                </ul>
            </div>

            {{-- Kanan: kartu statistik --}}
            <div class="col-xl-5">
                <div class="wl-glass-card mx-auto wl-reveal" style="--d: .2s; max-width: 480px;">
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-4">
                        <h2 class="h6 fw-bold m-0"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Status Inventaris</h2>
                        <span class="badge rounded-pill bg-success-subtle text-success-emphasis px-3 py-2 d-inline-flex align-items-center gap-2">
                            <span class="wl-live-dot"></span> Live
                        </span>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @foreach ([
                            ['icon' => 'bi-tags-fill',   'color' => 'primary', 'title' => 'Total Kategori',  'sub' => 'Pengelompokan barang',  'val' => $totalKategori ?? 0],
                            ['icon' => 'bi-tools',       'color' => 'primary', 'title' => 'Inventaris Alat', 'sub' => 'Fasilitas & barang',    'val' => $totalAlat ?? 0],
                            ['icon' => 'bi-people-fill', 'color' => 'success', 'title' => 'Pengguna Aktif',  'sub' => 'Admin, guru & siswa',   'val' => $totalPengguna ?? 0],
                        ] as $s)
                            <div class="wl-stat-row">
                                <div class="d-flex align-items-center gap-3 min-w-0">
                                    <div class="wl-icon-box text-{{ $s['color'] }} bg-{{ $s['color'] }}-subtle">
                                        <i class="bi {{ $s['icon'] }} fs-5"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="fw-bold text-truncate">{{ $s['title'] }}</div>
                                        <small class="text-body-secondary text-truncate d-block">{{ $s['sub'] }}</small>
                                    </div>
                                </div>
                                <span class="wl-stat-num text-{{ $s['color'] }}" data-count="{{ $s['val'] }}">{{ $s['val'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== RINGKASAN DATA ===================== --}}
<section id="ringkasan" class="wl-section bg-body-tertiary border-top border-bottom">
    <div class="container">
        <div class="text-center mb-5 wl-reveal">
            <span class="wl-eyebrow">Dashboard Interaktif</span>
            <h2 class="wl-h2">Ringkasan Data Terintegrasi</h2>
            <p class="text-body-secondary mx-auto" style="max-width: 560px;">
                Keterhubungan real-time antara kategori, inventaris alat, dan hak akses pengguna.
            </p>
        </div>

        <div class="row g-4">
            {{-- Kategori --}}
            <div class="col-md-6 col-xl-4 wl-reveal">
                <div class="wl-card wl-card-primary h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="wl-icon-box lg text-primary bg-primary-subtle"><i class="bi bi-tags-fill fs-4"></i></div>
                        <span class="wl-count bg-primary" data-count="{{ $totalKategori ?? 0 }}">{{ $totalKategori ?? 0 }}</span>
                    </div>
                    <h3 class="h5 fw-bold mb-1">Kategori Terdaftar</h3>
                    <p class="text-body-secondary small mb-3">Pengelompokan jenis sarana &amp; prasarana sekolah.</p>
                    <hr class="opacity-25 my-2">

                    <div class="flex-grow-1 mb-3">
                        <span class="wl-label">Daftar Kategori Utama</span>
                        <div class="d-flex flex-wrap gap-2">
                            @forelse($kategoriList ?? [] as $kat)
                                <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis border border-primary-subtle fw-semibold py-2 px-3">
                                    {{ $kat->nama_kategori }}
                                    <span class="badge bg-primary rounded-pill ms-1">{{ $kat->alat_count ?? $kat->alat->count() ?? 0 }}</span>
                                </span>
                            @empty
                                <small class="text-body-secondary fst-italic">Belum ada kategori terdaftar.</small>
                            @endforelse
                        </div>
                    </div>

                    @if ($isAdmin)
                        <a href="{{ route('kategori.index') }}" class="btn wl-btn-soft-primary w-100 rounded-pill fw-bold py-2 mt-auto">
                            Kelola Kategori <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Alat --}}
            <div class="col-md-6 col-xl-4 wl-reveal" style="--d: .08s;">
                <div class="wl-card wl-card-primary h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="wl-icon-box lg text-primary bg-primary-subtle"><i class="bi bi-tools fs-4"></i></div>
                        <span class="wl-count bg-primary" data-count="{{ $totalAlat ?? 0 }}">{{ $totalAlat ?? 0 }}</span>
                    </div>
                    <h3 class="h5 fw-bold mb-1">Total Alat &amp; Barang</h3>
                    <p class="text-body-secondary small mb-3">Inventaris alat praktikum &amp; fasilitas sekolah.</p>
                    <hr class="opacity-25 my-2">

                    <div class="flex-grow-1 mb-3">
                        <span class="wl-label">Contoh Alat Terhubung</span>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                            @forelse($alatList ?? [] as $item)
                                <li class="wl-list-item">
                                    <span class="text-truncate fw-semibold"><i class="bi bi-box-seam text-primary me-2"></i>{{ $item->nama_alat }}</span>
                                    <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill flex-shrink-0">{{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}</span>
                                </li>
                            @empty
                                <li class="text-body-secondary small fst-italic">Belum ada data alat terdaftar.</li>
                            @endforelse
                        </ul>
                    </div>

                    @if ($currentUser)
                        <a href="{{ route('alat.index') }}" class="btn wl-btn-soft-primary w-100 rounded-pill fw-bold py-2 mt-auto">
                            Kelola Alat <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Pengguna --}}
            <div class="col-md-12 col-xl-4 wl-reveal" style="--d: .16s;">
                <div class="wl-card wl-card-success h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="wl-icon-box lg text-success bg-success-subtle"><i class="bi bi-people-fill fs-4"></i></div>
                        <span class="wl-count bg-success" data-count="{{ $totalPengguna ?? 0 }}">{{ $totalPengguna ?? 0 }}</span>
                    </div>
                    <h3 class="h5 fw-bold mb-1">Pengguna Terdaftar</h3>
                    <p class="text-body-secondary small mb-3">Administrator, guru, dan siswa yang aktif.</p>
                    <hr class="opacity-25 my-2">

                    <div class="flex-grow-1 mb-3">
                        <span class="wl-label">Pengguna Aktif Terbaru</span>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                            @forelse($penggunaList ?? [] as $user)
                                <li class="wl-list-item">
                                    <span class="text-truncate fw-semibold"><i class="bi bi-person-circle text-success me-2"></i>{{ $user->name ?? $user->nama }}</span>
                                    <span class="badge bg-success-subtle text-success-emphasis text-uppercase rounded-pill flex-shrink-0" style="font-size: .65rem;">{{ $user->role ?? 'User' }}</span>
                                </li>
                            @empty
                                <li class="text-body-secondary small fst-italic">Belum ada pengguna terdaftar.</li>
                            @endforelse
                        </ul>
                    </div>

                    @if ($isAdmin)
                        <a href="{{ route('pengguna.index') }}" class="btn wl-btn-soft-success w-100 rounded-pill fw-bold py-2 mt-auto">
                            Kelola Pengguna <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== KEUNGGULAN ===================== --}}
<section class="wl-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-xl-5 text-center text-xl-start wl-reveal">
                <span class="wl-eyebrow">Keunggulan Sarpras</span>
                <h2 class="wl-h2">Mengapa Menggunakan Sistem Ini?</h2>
                <p class="text-body-secondary">
                    Dibangun untuk kebutuhan digitalisasi SMK Sangkuriang 1 Cimahi: transparan, cepat,
                    dan mudah dipakai oleh seluruh warga sekolah.
                </p>
            </div>

            <div class="col-xl-7">
                <div class="row g-3">
                    @foreach ([
                        ['bi-lightning-charge-fill', 'Real-time Tracking', 'Pantau ketersediaan alat langsung dari perangkat apa saja.'],
                        ['bi-diagram-3-fill',        'Terstruktur & Relasional', 'Barang dikelompokkan per kategori dengan hak akses yang ketat.'],
                        ['bi-shield-lock-fill',      'Aman & Terkontrol', 'Login berlapis sesuai role: Admin, Guru, dan Siswa.'],
                        ['bi-phone-fill',            'Responsive Design', 'Nyaman di komputer, tablet, maupun smartphone.'],
                    ] as $i => $f)
                        <div class="col-sm-6 wl-reveal" style="--d: {{ $i * 0.07 }}s;">
                            <div class="wl-feature h-100">
                                <div class="wl-icon-box lg text-primary bg-primary-subtle mb-3"><i class="bi {{ $f[0] }} fs-4"></i></div>
                                <h3 class="h6 fw-bold mb-2">{{ $f[1] }}</h3>
                                <p class="text-body-secondary small mb-0">{{ $f[2] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== PANDUAN ===================== --}}
<section id="panduan" class="wl-section bg-body-tertiary border-top">
    <div class="container">
        <div class="text-center mb-5 wl-reveal">
            <span class="wl-eyebrow">Panduan Singkat</span>
            <h2 class="wl-h2">Langkah Penggunaan Aplikasi</h2>
            <p class="text-body-secondary">Alur kerja terintegrasi antara kategori, alat, dan pengguna.</p>
        </div>

        <div class="row g-4 wl-steps">
            @foreach ([
                ['Login Pengguna',   'Masuk dengan akun terdaftar sesuai hak akses masing-masing.'],
                ['Kelola Kategori',  'Admin membuat kategori untuk memudahkan pemetaan inventaris.'],
                ['Hubungkan Alat',   'Input data alat dan pilih kategori yang sesuai.'],
                ['Pantau Inventaris','Seluruh warga sekolah memantau ketersediaan barang.'],
            ] as $i => $st)
                <div class="col-sm-6 col-xl-3 wl-reveal" style="--d: {{ $i * 0.08 }}s;">
                    <div class="wl-step h-100">
                        <div class="wl-step-num">{{ $i + 1 }}</div>
                        <h3 class="h6 fw-bold mb-2">{{ $st[0] }}</h3>
                        <p class="text-body-secondary small mb-0">{{ $st[1] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== CTA PENUTUP ===================== --}}
<section class="wl-section pt-0 pb-5">
    <div class="container">
        <div class="wl-cta text-center text-md-start wl-reveal">
            <div class="row align-items-center g-3">
                <div class="col-md">
                    <h2 class="h3 fw-bold text-white mb-2">Siap mengelola sarana &amp; prasarana sekolah?</h2>
                    <p class="text-white-50 mb-0">Masuk sekarang dan mulai pantau inventaris secara real-time.</p>
                </div>
                <div class="col-md-auto">
                    <a href="{{ $ctaUrl }}" class="btn btn-light btn-lg rounded-pill px-4 fw-bold text-primary w-100">
                        {{ $ctaLabel }} <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== STYLE ===================== --}}
<style>
    :root { color-scheme: light dark; }
    html { scroll-behavior: smooth; }
    .min-w-0 { min-width: 0; }

    /* ---------- Hero ---------- */
    .wl-hero {
        background:
            radial-gradient(900px 480px at 15% -10%, rgba(13,110,253,.16), transparent 60%),
            radial-gradient(700px 420px at 100% 100%, rgba(13,202,240,.14), transparent 60%);
    }
    .wl-hero::before {
        content: ""; position: absolute; inset: 0; z-index: 1; pointer-events: none;
        background-image:
            linear-gradient(var(--bs-border-color) 1px, transparent 1px),
            linear-gradient(90deg, var(--bs-border-color) 1px, transparent 1px);
        background-size: 44px 44px;
        opacity: .35;
        -webkit-mask-image: radial-gradient(ellipse at center, #000 30%, transparent 75%);
                mask-image: radial-gradient(ellipse at center, #000 30%, transparent 75%);
    }
    .wl-orb { position: absolute; border-radius: 50%; filter: blur(70px); z-index: 1; animation: wl-float 9s ease-in-out infinite; }
    .wl-orb-1 { width: min(520px, 80vw); height: 360px; top: -120px; left: 50%; transform: translateX(-50%); background: rgba(13,110,253,.22); }
    .wl-orb-2 { width: min(320px, 60vw); height: 320px; bottom: -100px; right: -60px; background: rgba(13,202,240,.2); animation-delay: -4s; }
    @keyframes wl-float { 50% { translate: 0 -22px; } }

    .wl-pill {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .5rem 1.1rem; border-radius: 999px;
        font-weight: 800; font-size: .8rem; letter-spacing: .08em;
        color: var(--bs-primary-text-emphasis); background: var(--bs-primary-bg-subtle);
        border: 1px solid var(--bs-primary-border-subtle);
    }
    .wl-logo { width: min(300px, 80%); height: auto; color: var(--bs-body-color); }
    .wl-title { font-size: clamp(1.9rem, 1.2rem + 3vw, 3.4rem); font-weight: 800; line-height: 1.12; letter-spacing: -.02em; }
    .wl-gradient-text {
        background: linear-gradient(135deg, #3d8bfd 0%, #0d6efd 45%, #0a58ca 100%);
        -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;
    }
    .wl-lead { max-width: 580px; font-size: clamp(1rem, .95rem + .3vw, 1.15rem); line-height: 1.75; }

    .wl-btn-primary {
        color: #fff; border: 0;
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        box-shadow: 0 10px 24px rgba(13,110,253,.35);
        transition: transform .2s, box-shadow .2s;
    }
    .wl-btn-primary:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 14px 30px rgba(13,110,253,.45); }

    /* ---------- Kartu statistik hero ---------- */
    .wl-glass-card {
        padding: clamp(1.1rem, 3vw, 1.75rem);
        border-radius: 1.5rem;
        background: color-mix(in srgb, var(--bs-body-bg) 82%, transparent);
        -webkit-backdrop-filter: blur(14px); backdrop-filter: blur(14px);
        border: 1px solid var(--bs-border-color);
        border-top: 4px solid var(--bs-primary);
        box-shadow: 0 24px 48px rgba(13,110,253,.12);
    }
    .wl-stat-row {
        display: flex; align-items: center; justify-content: space-between; gap: .75rem;
        padding: .85rem 1rem; border-radius: 1rem;
        background: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);
        transition: transform .2s, border-color .2s;
    }
    .wl-stat-row:hover { transform: translateX(4px); border-color: var(--bs-primary-border-subtle); }
    .wl-stat-num { font-size: clamp(1.4rem, 1.1rem + 1vw, 1.9rem); font-weight: 800; line-height: 1; font-variant-numeric: tabular-nums; }
    .wl-icon-box {
        width: 44px; height: 44px; flex-shrink: 0; border-radius: .85rem;
        display: inline-flex; align-items: center; justify-content: center;
    }
    .wl-icon-box.lg { width: 54px; height: 54px; border-radius: 1rem; }
    .wl-live-dot { width: 8px; height: 8px; border-radius: 50%; background: #198754; animation: wl-pulse 1.6s infinite; }
    @keyframes wl-pulse { 0% { box-shadow: 0 0 0 0 rgba(25,135,84,.6); } 100% { box-shadow: 0 0 0 9px rgba(25,135,84,0); } }

    /* ---------- Section umum ---------- */
    .wl-section { padding-block: clamp(3rem, 6vw, 5.5rem); }
    .wl-eyebrow { display: inline-block; margin-bottom: .6rem; font-size: .75rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: var(--bs-primary); }
    .wl-h2 { font-size: clamp(1.5rem, 1.1rem + 1.6vw, 2.2rem); font-weight: 800; letter-spacing: -.01em; margin-bottom: .75rem; }
    .wl-label { display: block; margin-bottom: .6rem; font-size: .7rem; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; color: var(--bs-secondary-color); }

    /* ---------- Kartu ringkasan ---------- */
    .wl-card {
        display: flex; flex-direction: column; padding: 1.5rem;
        border-radius: 1.25rem; background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color); border-top-width: 4px;
        box-shadow: 0 2px 10px rgba(0,0,0,.04);
        transition: transform .3s, box-shadow .3s;
    }
    .wl-card-primary { border-top-color: var(--bs-primary); }
    .wl-card-success { border-top-color: var(--bs-success); }
    .wl-card:hover, .wl-feature:hover, .wl-step:hover { transform: translateY(-6px); box-shadow: 0 18px 34px rgba(13,110,253,.14); }
    .wl-count { min-width: 3rem; padding: .35rem .9rem; border-radius: 999px; text-align: center; font-size: 1.15rem; font-weight: 800; color: #fff; font-variant-numeric: tabular-nums; }
    .wl-list-item {
        display: flex; align-items: center; justify-content: space-between; gap: .5rem; min-width: 0;
        padding: .55rem .85rem; border-radius: .75rem; font-size: .875rem;
        background: var(--bs-tertiary-bg); border: 1px solid var(--bs-border-color);
    }
    .wl-btn-soft-primary, .wl-btn-soft-success { border: 0; color: var(--bs-body-color); transition: all .2s; }
    .wl-btn-soft-primary { background: rgba(13,110,253,.12); }
    .wl-btn-soft-success { background: rgba(25,135,84,.12); }
    .wl-btn-soft-primary:hover { background: #0d6efd; color: #fff; }
    .wl-btn-soft-success:hover { background: #198754; color: #fff; }

    /* ---------- Keunggulan & langkah ---------- */
    .wl-feature, .wl-step {
        padding: 1.5rem; border-radius: 1.25rem; background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color); box-shadow: 0 2px 10px rgba(0,0,0,.04);
        transition: transform .3s, box-shadow .3s;
    }
    .wl-step { text-align: center; position: relative; }
    .wl-step-num {
        width: 48px; height: 48px; margin: 0 auto 1rem; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: #fff; background: linear-gradient(135deg, #3d8bfd, #0a58ca);
        box-shadow: 0 8px 18px rgba(13,110,253,.35);
    }
    /* Garis penghubung antar langkah (hanya layar lebar) */
    @media (min-width: 1200px) {
        .wl-steps > div:not(:last-child) .wl-step::after {
            content: ""; position: absolute; top: 2.9rem; left: calc(50% + 34px);
            width: calc(100% - 68px + 1.5rem); border-top: 2px dashed var(--bs-primary-border-subtle);
        }
    }

    /* ---------- CTA ---------- */
    .wl-cta {
        padding: clamp(1.5rem, 4vw, 2.75rem); border-radius: 1.75rem;
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 60%, #052c65 100%);
        box-shadow: 0 24px 48px rgba(13,110,253,.3);
    }

    /* ---------- Animasi muncul saat scroll (hanya aktif jika JS jalan) ---------- */
    .wl-js .wl-reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; transition-delay: var(--d, 0s); }
    .wl-js .wl-reveal.is-visible { opacity: 1; transform: none; }

    /* ---------- HP kecil ---------- */
    @media (max-width: 575.98px) {
        .wl-card, .wl-feature, .wl-step { padding: 1.15rem; }
        .wl-stat-row { padding: .7rem .8rem; }
    }
    @media (prefers-reduced-motion: reduce) {
        html { scroll-behavior: auto; }
        .wl-orb, .wl-live-dot { animation: none; }
        .wl-js .wl-reveal { opacity: 1; transform: none; transition: none; }
        .wl-card:hover, .wl-feature:hover, .wl-step:hover, .wl-stat-row:hover { transform: none; }
    }
</style>

<script>
    (function () {
        var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (reduce || !('IntersectionObserver' in window)) return;

        document.documentElement.classList.add('wl-js');

        // Animasi muncul saat di-scroll
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('.wl-reveal').forEach(function (el) { io.observe(el); });

        // Hitung naik angka statistik
        function countUp(el) {
            var target = parseInt(el.dataset.count, 10);
            if (isNaN(target) || target === 0) return;
            var start = null, dur = 1100;
            (function step(t) {
                if (!start) start = t;
                var p = Math.min((t - start) / dur, 1);
                el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
                if (p < 1) requestAnimationFrame(step);
            })(performance.now());
        }
        var cio = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { countUp(e.target); cio.unobserve(e.target); }
            });
        }, { threshold: 0.6 });
        document.querySelectorAll('[data-count]').forEach(function (el) { cio.observe(el); });
    })();
</script>
@endsection