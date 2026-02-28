@extends('layouts.base')
@section('title', config('app.name'))
@section('content')
    <section style="height: 620px" id="about">
        <div class="container h-100">
            <div class="row h-100 align-items-center flex-md-row-reverse g-0 g-md-5"
                style="justify-content: center !important;">
                <div class="col-12 col-md-6">
                    <img class="img-fluid rounded" src="{{ asset('static/img/dashboard-stuent-preview.png') }}"
                        alt="Dashboard Siswa">
                </div>
                <div class="col-12 col-md-6">
                    <p class="rounded-pill border border-primary d-inline-block px-4 text-primary mb-2"
                        style="box-shadow: inset 0 0 5px 0.5px rgba(var(--bs-primary-rgb), 0.4);">Suarakan Aspirasimu
                        Sekarang</p>
                    <h1 class="display-5 fw-bold ff-inter text-primary">PeSarana</h1>
                    <p class="text-muted fw-medium ff-open-sans">PeSarana merupakan aplikasi PeNgaduan dan PeLaporan sarana
                        atau prasarana sekolah berbasis website. Siswa dapat membuat aspirasi melalui halaman dashboard. Ayo
                        daftarkan akun-mu sekarang dan mulai membuat aspirasi.</p>
                    <div class="d-flex align-items-center gap-2">
                        <a href="#"
                            class="fw-medium d-flex align-items-center gap-2 btn btn-sm btn-outline-primary px-4">
                            Daftar Sekarang
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="#" class="fw-medium d-flex align-items-center gap-2 btn btn-sm btn-primary px-4">
                            Lihat Fitur
                            <i class="bi bi-book-half"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5" id="stats">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 text-center">
                    <h2 class="fw-bold text-primary mb-0">Statistik PeSarana</h2>
                    <p class="text-muted mb-0">Ringkasan data sistem aspirasi sekolah</p>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 h-100 text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-people-fill display-5 text-primary"></i>
                        </div>
                        <h3 class="fw-bold">{{ $stats['students_count'] }}</h3>
                        <p class="text-muted mb-0">Total Data Siswa</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 h-100 text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-person-badge-fill display-5 text-primary"></i>
                        </div>
                        <h3 class="fw-bold">{{ $stats['student_users_count'] }}</h3>
                        <p class="text-muted mb-0">User Siswa Terdaftar</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 h-100 text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-chat-dots-fill display-5 text-primary"></i>
                        </div>
                        <h3 class="fw-bold">{{ $stats['aspirations_count'] }}</h3>
                        <p class="text-muted mb-0">Total Aspirasi</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card border-0 h-100 text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-check-circle-fill display-5 text-primary"></i>
                        </div>
                        <h3 class="fw-bold">{{ $stats['completed_aspirations_count'] }}</h3>
                        <p class="text-muted mb-0">Aspirasi Selesai</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
