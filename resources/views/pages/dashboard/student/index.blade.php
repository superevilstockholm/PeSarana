@extends('layouts.dashboard')
@section('title', 'Siswa - ' . config('app.name'))
@section('content')
    <div class="row">
        <div class="col mb-0">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                    <div>
                        <h3 class="fw-semibold mb-1 fs-3">Selamat datang, <span
                                class="text-primary"></span>{{ $user->name }}! 👋</h3>
                        <p class="text-muted mb-0">
                            Berikut adalah informasi statistik website {{ config('app.name') }}
                        </p>
                    </div>
                    <div class="d-none d-sm-block">
                        <img src="{{ asset('static/img/logo-horizontal.svg') }}" alt="Dashboard" height="40">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-12 col-sm-6 col-md-3 mb-0">
            <div class="card border-0 mb-0 shadow-sm rounded-3 text-center py-4 position-relative overflow-hidden">
                <div class="position-absolute bg-warning rounded-circle top-0 end-0 p-0 m-0 opacity-25"
                    style="width: 170px; height: 170px; transform: translate(60%, -50%);"></div>
                <div class="position-absolute bg-warning rounded-circle top-100 end-0 p-0 m-0 opacity-50"
                    style="width: 120px; height: 120px; transform: translate(60%, -50%);"></div>
                <i class="ti ti-file-text fs-2 text-warning mb-2"></i>
                <h5 class="fw-bold mb-0">{{ $stats['student_aspirations_count'] ?? 0 }}</h5>
                <small class="text-muted fs-09">Jumlah Aspirasi</small>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-0">
            <div class="card border-0 mb-0 shadow-sm rounded-3 text-center py-4 position-relative overflow-hidden">
                <div class="position-absolute bg-primary rounded-circle top-0 end-0 p-0 m-0 opacity-25"
                    style="width: 170px; height: 170px; transform: translate(60%, -50%);"></div>
                <div class="position-absolute bg-primary rounded-circle top-100 end-0 p-0 m-0 opacity-50"
                    style="width: 120px; height: 120px; transform: translate(60%, -50%);"></div>
                <i class="ti ti-clock fs-2 text-primary mb-2"></i>
                <h5 class="fw-bold mb-0">{{ $stats['student_pending_aspirations_count'] ?? 0 }}</h5>
                <small class="text-muted fs-09">Jumlah Aspirasi Menunggu</small>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-0">
            <div class="card border-0 mb-0 shadow-sm rounded-3 text-center py-4 position-relative overflow-hidden">
                <div class="position-absolute bg-warning rounded-circle top-0 end-0 p-0 m-0 opacity-25"
                    style="width: 170px; height: 170px; transform: translate(60%, -50%);"></div>
                <div class="position-absolute bg-warning rounded-circle top-100 end-0 p-0 m-0 opacity-50"
                    style="width: 120px; height: 120px; transform: translate(60%, -50%);"></div>
                <i class="ti ti-refresh fs-2 text-warning mb-2"></i>
                <h5 class="fw-bold mb-0">{{ $stats['student_on_going_aspirations_count'] ?? 0 }}</h5>
                <small class="text-muted fs-09">Jumlah Aspirasi Proses</small>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-0">
            <div class="card border-0 mb-0 shadow-sm rounded-3 text-center py-4 position-relative overflow-hidden">
                <div class="position-absolute bg-success rounded-circle top-0 end-0 p-0 m-0 opacity-25"
                    style="width: 170px; height: 170px; transform: translate(60%, -50%);"></div>
                <div class="position-absolute bg-success rounded-circle top-100 end-0 p-0 m-0 opacity-50"
                    style="width: 120px; height: 120px; transform: translate(60%, -50%);"></div>
                <i class="ti ti-check fs-2 text-success mb-2"></i>
                <h5 class="fw-bold mb-0">{{ $stats['student_completed_aspirations_count'] ?? 0 }}</h5>
                <small class="text-muted fs-09">Jumlah Aspirasi Selesai</small>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-0">
            <div class="card border-0 mb-0 shadow-sm rounded-3 text-center py-4 position-relative overflow-hidden">
                <div class="position-absolute bg-danger rounded-circle top-0 end-0 p-0 m-0 opacity-25"
                    style="width: 170px; height: 170px; transform: translate(60%, -50%);"></div>
                <div class="position-absolute bg-danger rounded-circle top-100 end-0 p-0 m-0 opacity-50"
                    style="width: 120px; height: 120px; transform: translate(60%, -50%);"></div>
                <i class="ti ti-x fs-2 text-danger mb-2"></i>
                <h5 class="fw-bold mb-0">{{ $stats['student_rejected_aspirations_count'] ?? 0 }}</h5>
                <small class="text-muted fs-09">Jumlah Aspirasi Ditolak</small>
            </div>
        </div>
    </div>
@endsection
