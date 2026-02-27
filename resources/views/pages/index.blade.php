@extends('layouts.base')
@section('title', config('app.name'))
@section('content')
<section style="height: 620px">
    <div class="container h-100">
        <div class="row h-100 align-items-center flex-md-row-reverse g-0 g-md-5" style="justify-content: center !important;">
            <div class="col-12 col-md-6">
                <img class="img-fluid rounded" src="{{ asset('static/img/dashboard-stuent-preview.png') }}" alt="Dashboard Siswa">
            </div>
            <div class="col-12 col-md-6">
                <p class="rounded-pill border border-primary d-inline-block px-4 text-primary mb-2" style="box-shadow: inset 0 0 5px 0.5px rgba(var(--bs-primary-rgb), 0.4);">Suarakan Aspirasimu Sekarang</p>
                <h1 class="display-5 fw-bold ff-inter text-primary">PeSarana</h1>
                <p class="text-muted fw-medium ff-open-sans">PeSarana merupakan aplikasi PeNgaduan dan PeLaporan sarana atau prasarana sekolah berbasis website. Siswa dapat membuat aspirasi melalui halaman dashboard. Ayo daftarkan akun-mu sekarang dan mulai membuat aspirasi.</p>
                <div class="d-flex align-items-center gap-2">
                    <a href="#" class="fw-medium d-flex align-items-center gap-2 btn btn-sm btn-outline-primary px-4">
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
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col">

            </div>
        </div>
    </div>
</section>
@endsection
