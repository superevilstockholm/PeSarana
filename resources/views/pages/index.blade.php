@extends('layouts.base')
@section('title', config('app.name'))
@section('content')
<section class="my-5">
    <div class="container">
        <div class="row align-items-center flex-md-row-reverse g-md-5">
            <div class="col-12 col-md-6">
                <img class="img-fluid rounded shadow" src="{{ asset('static/img/dashboard-stuent-preview.png') }}" alt="Dashboard Siswa">
            </div>
            <div class="col-12 col-md-6">
                <h1 class="display-5 fw-semibold ff-inter">PeSarana</h1>
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
@endsection
