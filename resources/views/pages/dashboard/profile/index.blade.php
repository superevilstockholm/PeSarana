@extends('layouts.dashboard')
@section('title', 'Profil - ' . config('app.name'))
@section('content')
    <x-alerts :errors="$errors" />
    @php
        use Illuminate\Support\Str;
        use App\Enums\RoleEnum;
    @endphp
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Profil Pengguna</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Informasi profil: {{ $user->name ? ucwords(strtolower($user->name)) : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12 text-muted mb-3">Foto Profil</div>
                        <div class="col-12">
                            <img class="object-fit-cover rounded" style="height: 150px; width: 150px;" src="{{ $user->profile_picture_path_url }}" alt="{{ $user->name ?? '-' }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Nama</div>
                        <div class="col-md-8 fw-medium">{{ $user->name ? ucwords(strtolower($user->name)) : '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Email</div>
                        <div class="col-md-8 fw-medium">{{ $user->email ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Role</div>
                        <div class="col-md-8 fw-medium">{{ $user->role->label() ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Tanggal Dibuat</div>
                        <div class="col-md-8 fw-medium">{{ $user->created_at?->format('d M Y H:i:s') ?? '-' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-muted">Terakhir Diperbarui</div>
                        <div class="col-md-8 fw-medium">{{ $user->updated_at?->format('d M Y H:i:s') ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card my-0">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-3">Aksi Cepat</h4>
                    <a href="{{ route('dashboard.profile.edit') }}" class="btn btn-warning w-100 mb-2">
                        <i class="ti ti-pencil me-1"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
