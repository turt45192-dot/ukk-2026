@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="container-fluid py-2">
    {{-- Banner Utama Admin --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 custom-dashboard-card">
        <div class="card-body p-4 p-md-5 position-relative">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="badge rounded-pill badge-admin-area px-3 py-2 fw-semibold">
                    <i class="bi bi-shield-lock-fill me-1"></i> Area Admin
                </span>
                <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                    <i class="bi bi-shield-check me-1"></i> Middleware Active
                </span>
            </div>

            <h1 class="h3 fw-bold mb-2 text-adaptive">
                Halo, {{ $user->username }}! 👋
            </h1>
            <p class="text-secondary-adaptive mb-0" style="max-width: 650px;">
                Halaman ini khusus untuk kontrol administrator. Hanya akun dengan role <code class="code-custom">admin</code> yang dapat mengakses fitur manajemen sistem di bawah ini.
            </p>

            {{-- Watermark Ikon Admin Transparan --}}
            <div class="position-absolute end-0 bottom-0 opacity-10 d-none d-md-block pe-4 pb-2 pointer-events-none">
                <i class="bi bi-gear-wide-connected text-adaptive" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    {{-- Grid Menu Admin --}}
    <div class="row g-4">
        {{-- Card Manage Role --}}
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('admin.roles.index') }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100 action-card">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="p-3 rounded-3 bg-primary-subtle text-primary">
                                <i class="bi bi-person-gear fs-3"></i>
                            </div>
                            <i class="bi bi-arrow-right text-secondary-adaptive fs-5 arrow-icon"></i>
                        </div>
                        <h2 class="h6 fw-bold mb-1 text-adaptive">Manage Role</h2>
                        <p class="text-secondary-adaptive small mb-0">
                            Tambah dan kelola role baru untuk menentukan hak akses pengguna aplikasi.
                        </p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Card Manage User --}}
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('admin.users.index') }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100 action-card">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="p-3 rounded-3 bg-success-subtle text-success">
                                <i class="bi bi-people-fill fs-3"></i>
                            </div>
                            <i class="bi bi-arrow-right text-secondary-adaptive fs-5 arrow-icon"></i>
                        </div>
                        <h2 class="h6 fw-bold mb-1 text-adaptive">Manage User</h2>
                        <p class="text-secondary-adaptive small mb-0">
                            Tambah pengguna baru, perbarui data akun, serta tentukan role pengaksesnya.
                        </p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Card Download Database --}}
        <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('admin.database.export') }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100 action-card">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="p-3 rounded-3 bg-warning-subtle text-warning">
                                <i class="bi bi-database-down fs-3"></i>
                            </div>
                            <i class="bi bi-download text-secondary-adaptive fs-5 arrow-icon"></i>
                        </div>
                        <h2 class="h6 fw-bold mb-1 text-adaptive">Download Database</h2>
                        <p class="text-secondary-adaptive small mb-0">
                            Unduh seluruh cadangan isi database ke file <code>.sql</code> untuk kebutuhan migrasi server.
                        </p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

{{-- Styling Responsif Light Mode & Dark Mode --}}
<style>
    /* Menggunakan Variabel CSS Bootstrap Bawaan untuk Dark Mode */
    .custom-dashboard-card,
    .action-card {
        background-color: var(--bs-card-bg);
        border: 1px solid var(--bs-border-color-translucent) !important;
        transition: transform 0.25s ease, box-shadow 0.25s ease, background-color 0.3s ease;
    }

    /* Efek Hover Interaktif pada Menu Admin */
    .action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08) !important;
    }

    .action-card:hover .arrow-icon {
        transform: translateX(4px);
        color: var(--bs-primary) !important;
    }

    .arrow-icon {
        transition: transform 0.2s ease, color 0.2s ease;
    }

    /* Badge Khusus Area Admin */
    .badge-admin-area {
        background-color: var(--bs-primary-bg-subtle);
        color: var(--bs-primary);
        border: 1px solid var(--bs-primary-border-subtle);
    }

    /* Teks Kode Inline Adaptif Theme */
    .code-custom {
        background-color: var(--bs-tertiary-bg);
        color: var(--bs-primary);
        padding: 0.15rem 0.4rem;
        border-radius: 0.375rem;
        font-size: 0.875em;
    }

    /* Penyesuaian Warna Teks Adaptif */
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