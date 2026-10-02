@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid py-2">
    {{-- Banner Utama --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 custom-dashboard-card">
        <div class="card-body p-4 p-md-5 position-relative">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="badge rounded-pill badge-role px-3 py-2 text-capitalize fw-semibold">
                    <i class="bi bi-person-badge me-1"></i> Role: {{ $user->role }}
                </span>
                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2">
                    <i class="bi bi-circle-fill me-1 small"></i> Online
                </span>
            </div>

            <h1 class="h3 fw-bold mb-2 text-adaptive">
                Selamat Datang, {{ $user->username }}! 👋
            </h1>
            <p class="text-secondary-adaptive mb-0" style="max-width: 600px;">
                Ini adalah halaman dashboard umum. Anda dapat mengakses fitur-fitur sesuai dengan hak akses role akun Anda.
            </p>

            {{-- Hiasan Ikon Transparan di Belakang --}}
            <div class="position-absolute end-0 bottom-0 opacity-10 d-none d-md-block pe-4 pb-2 pointer-events-none">
                <i class="bi bi-grid-3x3-gap-fill text-adaptive" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    {{-- Kartu Ringkasan Cepat --}}
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 feature-card">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-primary-subtle text-primary">
                        <i class="bi bi-person-circle fs-3"></i>
                    </div>
                    <div>
                        <small class="text-secondary-adaptive d-block">Pengguna</small>
                        <strong class="text-adaptive">{{ $user->username }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 feature-card">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-info-subtle text-info">
                        <i class="bi bi-shield-check fs-3"></i>
                    </div>
                    <div>
                        <small class="text-secondary-adaptive d-block">Akses Role</small>
                        <strong class="text-adaptive text-capitalize">{{ $user->role }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 feature-card">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-warning-subtle text-warning">
                        <i class="bi bi-clock-history fs-3"></i>
                    </div>
                    <div>
                        <small class="text-secondary-adaptive d-block">Status Sesi</small>
                        <strong class="text-adaptive">Aktif</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styling Khusus untuk Aksentuasi Light & Dark Mode --}}
<style>
    /* Styling Kartu Utama & Adaptif Dark Mode */
    .custom-dashboard-card,
    .feature-card {
        background-color: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color-translucent) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
    }

    /* Badge Role yang Menyesuaikan Theme */
    .badge-role {
        background-color: var(--bs-primary-bg-subtle);
        color: var(--bs-primary);
        border: 1px solid var(--bs-primary-border-subtle);
    }

    /* Kustomisasi Teks untuk Selaras di Dark/Light Mode */
    .text-adaptive {
        color: var(--bs-body-color) !important;
    }

    .text-secondary-adaptive {
        color: var(--bs-secondary-color) !important;
    }

    .pointer-events-none {
        pointer-events: none;
    }
</style>

@endsection