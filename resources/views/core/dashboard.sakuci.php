@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $role = strtolower((string) ($user->role ?? 'siswa'));
    $username = (string) ($user->username ?? 'Pengguna');
    $isAdmin = $role === 'admin';

    // Inisial untuk avatar
    $initial = function_exists('mb_substr')
        ? mb_strtoupper(mb_substr($username, 0, 1))
        : strtoupper(substr($username, 0, 1));

    // Penjelasan singkat hak akses per role
    $roleDesc = [
        'admin' => 'Akses penuh: kelola kategori, alat, pengguna, dan aspirasi.',
        'guru'  => 'Kelola data alat dan pantau aspirasi sekolah.',
        'siswa' => 'Lihat inventaris alat dan sampaikan aspirasi Anda.',
    ];
    $roleText = $roleDesc[$role] ?? 'Akses fitur sesuai hak akses akun Anda.';

    // Pintasan menu sesuai role
    $shortcuts = [];
    $shortcuts[] = ['route' => route('alat.index'), 'icon' => 'bi-tools', 'color' => 'primary', 'title' => 'Alat & Fasilitas', 'desc' => 'Lihat dan pantau inventaris sarana prasarana.'];
    $shortcuts[] = ['route' => route('aspirasi.index'), 'icon' => 'bi-chat-left-text-fill', 'color' => 'info', 'title' => 'Aspirasi', 'desc' => 'Sampaikan dan pantau laporan masukan.'];
    if ($isAdmin) {
        $shortcuts[] = ['route' => route('kategori.index'), 'icon' => 'bi-grid-fill', 'color' => 'success', 'title' => 'Kategori', 'desc' => 'Atur pengelompokan alat dan barang.'];
        $shortcuts[] = ['route' => route('pengguna.index'), 'icon' => 'bi-people-fill', 'color' => 'warning', 'title' => 'Pengguna', 'desc' => 'Kelola data siswa yang terdaftar.'];
    }
@endphp

<div class="container-fluid px-0 py-3">

    {{-- ===== Banner Utama ===== --}}
    <section class="db-hero mb-4">
        <div class="db-orb db-orb-1" aria-hidden="true"></div>
        <div class="db-orb db-orb-2" aria-hidden="true"></div>

        <div class="position-relative d-flex flex-column flex-md-row align-items-center align-items-md-start gap-4" style="z-index: 2;">
            <div class="db-avatar" aria-hidden="true">{{ $initial }}</div>

            <div class="text-center text-md-start flex-grow-1 min-w-0">
                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2 mb-3">
                    <span class="db-pill">
                        <i class="bi bi-person-badge"></i> Role: <span class="text-capitalize">{{ $role }}</span>
                    </span>
                    <span class="db-pill db-pill-online">
                        <span class="db-dot"></span> Online
                    </span>
                </div>

                <h1 class="db-title mb-2 text-break">
                    <span id="dbGreeting">Selamat Datang</span>, {{ $username }}! 👋
                </h1>
                <p class="db-sub mb-0 mx-auto mx-md-0">{{ $roleText }}</p>
            </div>

            {{-- Jam & tanggal --}}
            <div class="db-clock text-center text-md-end flex-shrink-0">
                <div class="db-time" id="dbTime">--:--</div>
                <div class="db-date" id="dbDate">&nbsp;</div>
            </div>
        </div>
    </section>

    {{-- ===== Info Akun ===== --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="db-info">
                <div class="db-info-icon bg-primary-subtle text-primary"><i class="bi bi-person-circle"></i></div>
                <div class="min-w-0">
                    <small class="text-body-secondary d-block">Pengguna</small>
                    <strong class="d-block text-truncate">{{ $username }}</strong>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="db-info">
                <div class="db-info-icon bg-info-subtle text-info"><i class="bi bi-shield-check"></i></div>
                <div class="min-w-0">
                    <small class="text-body-secondary d-block">Akses Role</small>
                    <strong class="d-block text-capitalize">{{ $role }}</strong>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="db-info">
                <div class="db-info-icon bg-success-subtle text-success"><i class="bi bi-clock-history"></i></div>
                <div class="min-w-0">
                    <small class="text-body-secondary d-block">Status Sesi</small>
                    <strong class="d-block"><span class="db-dot me-1"></span>Aktif</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Pintasan Menu ===== --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h5 fw-bold mb-0"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Akses Cepat</h2>
    </div>

    <div class="row g-3">
        @foreach ($shortcuts as $s)
            <div class="col-12 col-sm-6 col-xl-3">
                <a href="{{ $s['route'] }}" class="db-tile text-decoration-none h-100">
                    <div class="db-tile-icon bg-{{ $s['color'] }}-subtle text-{{ $s['color'] }}">
                        <i class="bi {{ $s['icon'] }}"></i>
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="fw-bold text-body mb-1">{{ $s['title'] }}</div>
                        <small class="text-body-secondary d-block">{{ $s['desc'] }}</small>
                    </div>
                    <i class="bi bi-arrow-right db-arrow"></i>
                </a>
            </div>
        @endforeach
    </div>
</div>

<style>
    .min-w-0 { min-width: 0; }

    /* ---------- Banner ---------- */
    .db-hero {
        position: relative; overflow: hidden; padding: clamp(1.5rem, 4vw, 2.75rem);
        border-radius: 1.75rem; color: #fff;
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 55%, #052c65 100%);
        box-shadow: 0 24px 48px rgba(13,110,253,.28);
    }
    .db-hero::before {
        content: ""; position: absolute; inset: 0; pointer-events: none;
        background-image:
            linear-gradient(rgba(255,255,255,.07) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,.07) 1px, transparent 1px);
        background-size: 36px 36px;
        -webkit-mask-image: radial-gradient(ellipse at 70% 30%, #000 20%, transparent 75%);
                mask-image: radial-gradient(ellipse at 70% 30%, #000 20%, transparent 75%);
    }
    .db-orb { position: absolute; border-radius: 50%; filter: blur(60px); animation: db-float 9s ease-in-out infinite; }
    .db-orb-1 { width: 280px; height: 280px; top: -90px; right: -60px; background: rgba(61,139,253,.55); }
    .db-orb-2 { width: 220px; height: 220px; bottom: -90px; left: 10%; background: rgba(13,202,240,.35); animation-delay: -4s; }
    @keyframes db-float { 50% { translate: 0 -18px; } }

    .db-avatar {
        width: clamp(64px, 12vw, 88px); height: clamp(64px, 12vw, 88px); flex-shrink: 0; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: clamp(1.7rem, 4vw, 2.4rem); font-weight: 800;
        background: rgba(255,255,255,.18); border: 2px solid rgba(255,255,255,.45);
        -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px);
    }
    .db-pill {
        display: inline-flex; align-items: center; gap: .4rem; padding: .4rem .95rem; border-radius: 999px;
        font-size: .8rem; font-weight: 700; background: rgba(255,255,255,.16); border: 1px solid rgba(255,255,255,.3);
    }
    .db-pill-online { background: rgba(25,135,84,.35); border-color: rgba(120,230,170,.5); }
    .db-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #2ee59d; animation: db-pulse 1.8s infinite; }
    @keyframes db-pulse { 0% { box-shadow: 0 0 0 0 rgba(46,229,157,.6); } 100% { box-shadow: 0 0 0 9px rgba(46,229,157,0); } }

    .db-title { font-size: clamp(1.4rem, 1.1rem + 1.6vw, 2.1rem); font-weight: 800; letter-spacing: -.01em; }
    .db-sub { max-width: 560px; color: rgba(255,255,255,.85); }
    .db-time { font-size: clamp(1.8rem, 1.3rem + 2vw, 2.6rem); font-weight: 800; line-height: 1; font-variant-numeric: tabular-nums; }
    .db-date { margin-top: .35rem; font-size: .85rem; color: rgba(255,255,255,.8); }

    /* ---------- Info akun ---------- */
    .db-info {
        display: flex; align-items: center; gap: .9rem; padding: 1.1rem 1.25rem; height: 100%;
        border-radius: 1.25rem; background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color); box-shadow: 0 2px 10px rgba(0,0,0,.04);
    }
    .db-info-icon { width: 50px; height: 50px; flex-shrink: 0; border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }

    /* ---------- Pintasan ---------- */
    .db-tile {
        display: flex; align-items: center; gap: 1rem; padding: 1.15rem 1.25rem;
        border-radius: 1.25rem; background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color); box-shadow: 0 2px 10px rgba(0,0,0,.04);
        transition: transform .25s, box-shadow .25s, border-color .25s;
    }
    .db-tile:hover { transform: translateY(-4px); border-color: var(--bs-primary-border-subtle); box-shadow: 0 16px 30px rgba(13,110,253,.14); }
    .db-tile-icon { width: 52px; height: 52px; flex-shrink: 0; border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.55rem; }
    .db-arrow { color: var(--bs-secondary-color); transition: transform .25s, color .25s; }
    .db-tile:hover .db-arrow { color: var(--bs-primary); transform: translateX(4px); }

    /* ---------- HP kecil ---------- */
    @media (max-width: 575.98px) {
        .db-info, .db-tile { padding: 1rem; }
    }
    @media (prefers-reduced-motion: reduce) {
        .db-orb, .db-dot { animation: none; }
        .db-tile, .db-arrow { transition: none; }
        .db-tile:hover, .db-tile:hover .db-arrow { transform: none; }
    }
</style>

<script>
    (function () {
        var greet = document.getElementById('dbGreeting');
        var time = document.getElementById('dbTime');
        var date = document.getElementById('dbDate');

        // Sapaan, jam, dan tanggal mengikuti waktu perangkat pengguna
        function tick() {
            var now = new Date();
            var h = now.getHours();
            var g = h < 4 ? 'Selamat malam' : h < 11 ? 'Selamat pagi' : h < 15 ? 'Selamat siang' : h < 18 ? 'Selamat sore' : 'Selamat malam';
            if (greet) greet.textContent = g;
            if (time) time.textContent = ('0' + h).slice(-2) + ':' + ('0' + now.getMinutes()).slice(-2);
            if (date) {
                try {
                    date.textContent = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                } catch (e) { date.textContent = now.toDateString(); }
            }
        }
        tick();
        setInterval(tick, 20000);
    })();
</script>
@endsection