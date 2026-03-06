@extends('layouts.dashboard')
@section('title', 'Tambah Data Pengguna - ' . config('app.name'))
@section('content')
    <x-alerts :errors="$errors" />
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Tambah Pengguna</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Formulir untuk memasukkan data Pengguna baru.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.users.index') }}"
                            class="btn btn-sm btn-primary px-4 rounded-pill m-0">
                            <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card my-0">
                <div class="card-body">
                    <form action="{{ route('dashboard.admin.master-data.users.store') }}" autocomplete="off" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Foto Profil (Opsional)</label>
                            <div class="mb-3">
                                <img id="profilePreview" src="{{ asset('static/img/default-profile-picture.svg') }}"
                                    alt="Preview" class="rounded object-fit-cover" style="width:150px;height:150px;">
                            </div>
                            <input type="file" name="profile_picture_image" id="profile_picture_image" accept="image/*"
                                class="form-control form-control-sm @error('profile_picture_image') is-invalid @enderror">
                            @error('profile_picture_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="floatingInputEmail" placeholder="Email" value="{{ old('email') }}"
                                autocomplete="new-email" required>
                            <label for="floatingInputEmail">Email</label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" id="floatingInputPassword"
                                placeholder="Password" autocomplete="new-password" required>
                            <label for="floatingInputPassword">Password</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select name="role" class="form-select @error('role') is-invalid @enderror"
                                id="floatingSelectRole" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Siswa</option>
                            </select>
                            <label for="floatingSelectRole">Role</label>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3" id="name-wrapper">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="floatingInputName" placeholder="Nama" value="{{ old('name') }}">
                            <label for="floatingInputName">Nama</label>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3 d-none" id="student-wrapper">
                            <select name="student_id" class="form-select @error('student_id') is-invalid @enderror"
                                id="floatingSelectStudent">
                                <option value="">-- Pilih Siswa --</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}"
                                        {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="floatingSelectStudent">Siswa</label>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const roleSelect = document.getElementById('floatingSelectRole');
        const nameWrapper = document.getElementById('name-wrapper');
        const studentWrapper = document.getElementById('student-wrapper');
        function toggleFields() {
            if (roleSelect.value === 'student') {
                studentWrapper.classList.remove('d-none');
                nameWrapper.classList.add('d-none');
            } else if (roleSelect.value === 'admin') {
                nameWrapper.classList.remove('d-none');
                studentWrapper.classList.add('d-none');
            } else {
                nameWrapper.classList.add('d-none');
                studentWrapper.classList.add('d-none');
            }
        }
        roleSelect.addEventListener('change', toggleFields);
        toggleFields();
        const fileInput = document.getElementById('profile_picture_image');
        const preview = document.getElementById('profilePreview');
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
