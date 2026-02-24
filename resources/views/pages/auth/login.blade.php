@extends('layouts.base')
@section('title', 'Masuk - ' . config('app.name'))
@section('content')
    <section class="vh-100">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-12 col-md-7 col-lg-5 py-4">
                    <div class="card border-0">
                        <div class="card-header border-0 bg-transparent d-flex justify-content-center p-0 m-0">
                            <img class="text-center object-fit-cover" style="width: 160px; height: 120px;"
                                src="{{ asset('static/img/logo-vertical.svg') }}" alt="Logo PeSarana">
                        </div>
                        <div class="card-body border-0 bg-transparent py-0 m-0">
                            <h1 class="text-center fs-3 mb-1 ff-inter fw-semibold">Selamat Datang Kembali</h1>
                            <p class="text-center text-muted ff-open-sans fw-normal">Silakan masuk menggunakan akun Anda
                                untuk mengakses halaman dashboard.</p>
                            <form action="{{ route('login') }}" class="p-0 m-0" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control form-control-sm" id="email" name="email"
                                        value="{{ old('email') }}" autocomplete="current-email" autofocus>
                                </div>
                                <div class="mb-2">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control form-control-sm" id="password"
                                        name="password" value="{{ old('password') }}" autocomplete="current-password">
                                </div>
                                <x-alerts :errors="$errors"></x-alerts>
                                <p class="text-end p-0 m-0 mb-2">Lupa password? <a class="text-primary" href="#">Reset
                                        disini!</a></p>
                                <button class="btn btn-sm btn-primary w-100 mb-2" type="submit">Masuk</button>
                                <p class="p-0 m-0">Tidak memiliki akun? <a class="text-primary"
                                        href="{{ route('signup') }}">Daftar Disini!</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
