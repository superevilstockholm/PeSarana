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
                    <p class="text-muted mb-0 ff-open-sans">Ringkasan data sistem aspirasi sekolah</p>
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
    <section class="py-5" id="features">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 text-center">
                    <h2 class="fw-bold text-primary mb-0">Fitur Unggulan PeSarana</h2>
                    <p class="text-muted mb-0 ff-open-sans">Kemudahan pengelolaan aspirasi dan sarana sekolah</p>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 h-100 p-4">
                        <div class="mb-3 text-primary">
                            <i class="bi bi-pencil-square display-5 text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Buat Aspirasi</h5>
                        <p class="text-muted mb-0 ff-open-sans">
                            Siswa dapat membuat laporan atau aspirasi terkait sarana dan prasarana sekolah secara mudah
                            melalui dashboard.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 h-100 p-4">
                        <div class="mb-3 text-primary">
                            <i class="bi bi-clock-history display-5 text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Tracking Status</h5>
                        <p class="text-muted mb-0 ff-open-sans">
                            Pantau perkembangan aspirasi mulai dari diproses hingga selesai.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 h-100 p-4">
                        <div class="mb-3 text-primary">
                            <i class="bi bi-chat-left-text-fill display-5 text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Feedback Admin</h5>
                        <p class="text-muted mb-0 ff-open-sans">
                            Admin dapat memberikan tanggapan langsung terhadap setiap aspirasi yang dikirim oleh siswa.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 h-100 p-4">
                        <div class="mb-3 text-primary">
                            <i class="bi bi-shield-lock-fill display-5 text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Autentikasi Aman</h5>
                        <p class="text-muted mb-0 ff-open-sans">
                            Sistem login dengan pengelolaan hak akses yang terstruktur.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 h-100 p-4">
                        <div class="mb-3 text-primary">
                            <i class="bi bi-bar-chart-fill display-5 text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Statistik Dashboard</h5>
                        <p class="text-muted mb-0 ff-open-sans">
                            Menampilkan ringkasan data aspirasi, jumlah siswa, serta progres penyelesaian secara visual.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card border-0 h-100 p-4">
                        <div class="mb-3 text-primary">
                            <i class="bi bi-database-fill-gear display-5 text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Manajemen Data</h5>
                        <p class="text-muted mb-0 ff-open-sans">
                            Admin dapat mengelola data siswa, kategori aspirasi, serta konfigurasi sistem dengan fitur CRUD
                            lengkap.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5" id="faq">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 text-center">
                    <h2 class="fw-bold text-primary mb-0">FAQ PeSarana</h2>
                    <p class="text-muted mb-0 ff-open-sans">
                        Pertanyaan yang sering ditanyakan terkait sistem aspirasi sekolah
                    </p>
                </div>
                <div class="col-12 col-lg-8 mx-auto">
                    <div class="accordion mt-4" id="faqAccordion">
                        <div class="accordion-item border-0 border-bottom rounded-top">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faqOne">
                                    Bagaimana cara membuat aspirasi?
                                </button>
                            </h2>
                            <div id="faqOne" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted ff-open-sans">
                                    Login sebagai siswa, masuk ke dashboard, lalu klik tombol
                                    "Buat Aspirasi". Isi form yang tersedia dan kirim laporan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faqTwo">
                                    Apakah saya bisa melihat status aspirasi?
                                </button>
                            </h2>
                            <div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted ff-open-sans">
                                    Ya. Setiap aspirasi memiliki status seperti diproses,
                                    ditolak, atau selesai yang dapat dipantau melalui dashboard.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faqThree">
                                    Siapa yang memproses aspirasi?
                                </button>
                            </h2>
                            <div id="faqThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted ff-open-sans">
                                    Aspirasi diproses oleh admin sekolah yang bertugas
                                    meninjau, memberikan tanggapan, dan memperbarui status.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 border-bottom rounded-bottom">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faqFour">
                                    Apakah data saya aman?
                                </button>
                            </h2>
                            <div id="faqFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted ff-open-sans">
                                    Ya. Sistem menggunakan autentikasi login dan pengelolaan
                                    hak akses untuk memastikan keamanan data pengguna.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
