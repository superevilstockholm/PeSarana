@extends('layouts.dashboard')
@section('title', 'Data Siswa - ' . config('app.name'))
@section('content')
    <x-alerts :errors="$errors" />
    @php
        use Illuminate\Contracts\Pagination\LengthAwarePaginator;
    @endphp
    <div class="row mb-4">
        <div class="col">
            <div class="card my-0">
                <div
                    class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-2 gap-lg-5">
                    <div class="d-flex flex-column">
                        <h3 class="p-0 m-0 mb-1 fw-semibold">Data Siswa</h3>
                        <p class="p-0 m-0 fw-medium text-muted">Manajemen data siswa siswa.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard.admin.master-data.students.create') }}"
                            class="btn btn-sm btn-primary px-4 rounded-pill m-0">
                            <i class="ti ti-plus me-1"></i> Tambah Siswa
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
                    <form method="GET" action="{{ route('dashboard.admin.master-data.students.index') }}" id="filterForm">
                        <div
                            class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center mb-3 gap-2 gap-md-0">
                            <div class="d-flex align-items-center">
                                @php
                                    $limits = [5, 10, 25, 50, 100];
                                    $currentLimit = request('limit', 10);
                                @endphp
                                <label for="limitSelect" class="form-label mb-0 me-2">Limit</label>
                                <select class="form-select form-select-sm" id="limitSelect" name="limit"
                                    onchange="document.getElementById('filterForm').submit()">
                                    @foreach ($limits as $limit)
                                        <option value="{{ $limit }}"
                                            {{ (string) $currentLimit === (string) $limit ? 'selected' : '' }}>
                                            {{ $limit }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="ms-2">entries</span>
                            </div>
                            <div class="text-muted small">
                                @if ($students instanceof LengthAwarePaginator)
                                    Menampilkan {{ $students->firstItem() }} hingga {{ $students->lastItem() }} dari
                                    {{ $students->total() }} total entri
                                @else
                                    Menampilkan {{ $students->count() }} total entri
                                @endif
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row align-items-md-stretch mb-3 gap-2">
                            {{-- Select Filter Type --}}
                            <div class="form-floating" style="min-width: 180px;">
                                @php
                                    $filterTypes = [
                                        'nisn' => 'NISN',
                                        'name' => 'Nama Siswa',
                                        'date' => 'Tanggal Dibuat',
                                    ];
                                    $currentType = request('type') ?: array_key_first($filterTypes);
                                @endphp
                                <select class="form-select form-select-sm" id="filterType" name="type">
                                    @foreach ($filterTypes as $key => $label)
                                        <option value="{{ $key }}" {{ $currentType === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="filterType">Filter berdasarkan</label>
                            </div>
                            {{-- Input Text for Content --}}
                            <div class="form-floating flex-grow-1" id="filterTextWrapper">
                                <input type="text" name="search" class="form-control form-control-sm"
                                    id="filterTextInput" placeholder="Masukan kata kunci" value="{{ request('search') }}">
                                <label for="filterTextInput">Masukan kata kunci</label>
                            </div>
                            {{-- Date Fields --}}
                            <div class="form-floating flex-grow-1 d-none" id="filterStartDateWrapper">
                                <input type="date" name="start_date" class="form-control form-control-sm"
                                    id="filterStartDate" value="{{ request('start_date') }}">
                                <label for="filterStartDate">Tanggal Mulai</label>
                            </div>
                            <div class="form-floating flex-grow-1 d-none" id="filterEndDateWrapper">
                                <input type="date" name="end_date" class="form-control form-control-sm"
                                    id="filterEndDate" value="{{ request('end_date') }}">
                                <label for="filterEndDate">Tanggal Akhir</label>
                            </div>
                            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center">
                                <i class="ti ti-search"></i> Cari
                            </button>
                            <a href="{{ route('dashboard.admin.master-data.categories.index') }}"
                                class="btn btn-secondary d-flex align-items-center justify-content-center">
                                <i class="ti ti-rotate-clockwise-2"></i> Reset
                            </a>
                        </div>
                    </form>
                    <div class="table-responsive @if (!($students instanceof LengthAwarePaginator && $students->hasPages())) mb-0 @else mb-3 @endif">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Memiliki User</th>
                                    <th>Dibuat Pada</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $index => $student)
                                    <tr>
                                        <td class="text-center">
                                            @if ($students instanceof LengthAwarePaginator)
                                                {{ $students->firstItem() + $loop->index }}
                                            @else
                                                {{ $loop->iteration }}
                                            @endif
                                        </td>
                                        <td>{{ $student->nisn ?? '-' }}</td>
                                        <td>{{ $student->name ? ucwords(strtolower($student->name)) : '-' }}</td>
                                        <td>{{ $student->classroom?->name ?? '-' }}</td>
                                        <td>{{ $student->user ? 'Ya' : 'Tidak' }}</td>
                                        <td>{{ $student->created_at?->format('d M Y H:i') }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn border-0 p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item"
                                                        href="{{ route('dashboard.admin.master-data.students.show', $student->id) }}">
                                                        <i class="ti ti-eye me-1"></i> Lihat
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('dashboard.admin.master-data.students.edit', $student->id) }}">
                                                        <i class="ti ti-pencil me-1"></i> Edit
                                                    </a>
                                                    <form id="form-delete-{{ $student->id }}"
                                                        action="{{ route('dashboard.admin.master-data.students.destroy', $student->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="dropdown-item text-danger btn-delete"
                                                            data-id="{{ $student->id }}"
                                                            data-name="{{ $student->name }}">
                                                            <i class="ti ti-trash me-1 text-danger"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="alert alert-warning my-2" role="alert">
                                                Tidak ada data siswa yang ditemukan dengan kriteria tersebut.
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($students instanceof LengthAwarePaginator && $students->hasPages())
                        <div class="overflow-x-auto mt-0 py-1">
                            <div class="d-flex justify-content-center d-md-block w-100 px-3">
                                {{ $students->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const categoryId = this.getAttribute('data-id');
                    const categoryName = this.getAttribute('data-name');
                    Swal.fire({
                        title: "Hapus Siswa?",
                        text: "Apakah Anda yakin ingin menghapus Siswa \"" + categoryName +
                            "\"? Aksi ini tidak dapat dibatalkan.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('form-delete-' + categoryId).submit();
                        }
                    });
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('filterType');
            const textInputWrapper = document.getElementById('filterTextWrapper');
            const startDateWrapper = document.getElementById('filterStartDateWrapper');
            const endDateWrapper = document.getElementById('filterEndDateWrapper');
            function updateFilterFields() {
                const value = typeSelect.value;
                if (!value) {
                    textInputWrapper.classList.remove('d-none');
                    startDateWrapper.classList.add('d-none');
                    endDateWrapper.classList.add('d-none');
                    return;
                }
                if (value === 'date') {
                    textInputWrapper.classList.add('d-none');
                    startDateWrapper.classList.remove('d-none');
                    endDateWrapper.classList.remove('d-none');
                } else {
                    textInputWrapper.classList.remove('d-none');
                    startDateWrapper.classList.add('d-none');
                    endDateWrapper.classList.add('d-none');
                }
            }
            updateFilterFields();
            typeSelect.addEventListener('change', updateFilterFields);
        });
    </script>
@endsection
