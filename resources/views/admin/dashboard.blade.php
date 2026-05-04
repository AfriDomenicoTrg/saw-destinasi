@extends('layouts.app')

@section('title', 'Dashboard - Admin SPK Wisata')

@section('content')
<div class="fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold">Dashboard Admin</h1>
            <p class="text-muted">Selamat datang kembali!</p>
        </div>
        <div class="text-end">
            <span class="badge bg-primary rounded-pill px-3 py-2">
                <i class="fas fa-calendar-alt me-1"></i> {{ date('d F Y') }}
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Destinasi</p>
                            <h2 class="fw-bold mb-0">24</h2>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> +12%</small>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tambahkan card lainnya -->
    </div>
</div>
@endsection
