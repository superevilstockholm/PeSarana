<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\Student;
use App\Models\MasterData\Classroom;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $limit = (int) $request->query('limit', 10);
        if ($limit > 100) {
            $limit = 100;
        }
        $query = Student::query()->with(['classroom', 'user']);

        $allowed_types = [
            'nisn', 'name', 'date'
        ];
        $type = $request->query('type');
        if (in_array($type, $allowed_types)) {
            if ($type === 'date') {
                $start_date = $request->query('start_date');
                if ($start_date) {
                    $query->whereDate('created_at', '>=', Carbon::parse($start_date)->startOfDay());
                }
                $end_date = $request->query('end_date');
                if ($end_date) {
                    $query->whereDate('created_at', '<=', Carbon::parse($end_date)->endOfDay());
                }
            } else {
                $search = $request->query('search');
                if ($search) {
                    $query->where($type, 'ILIKE', '%' . $search . '%');
                }
            }
        }

        $students = $query->paginate($limit)->appends($request->except('page'));
        return view('pages.dashboard.admin.master-data.student.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'students' => $students,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $classrooms = Classroom::all();
        return view('pages.dashboard.admin.master-data.student.create', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'classrooms' => $classrooms,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nisn' => ['required', 'digits:10', 'unique:students,nisn'],
            'name' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'classroom_id' => ['required', 'exists:classrooms,id'],
        ]);
        Student::create($validated);
        return redirect()->route('dashboard.admin.master-data.students.index')->with('success', 'Berhasil membuat siswa.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): View
    {
        return view('pages.dashboard.admin.master-data.student.show', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'student' => $student->load(['classroom', 'user'])->loadCount(['aspirations']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {
        $classrooms = Classroom::all();
        return view('pages.dashboard.admin.master-data.student.edit', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'classrooms' => $classrooms,
            'student' => $student,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'nisn' => ['required', 'digits:10', 'unique:students,nisn,' . $student->id],
            'name' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'classroom_id' => ['required', 'exists:classrooms,id'],
        ]);
        $student->update($validated);
        return redirect()->route('dashboard.admin.master-data.students.index')->with('success', 'Berhasil mengubah siswa.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        if ($student->user) {
            $student->user->delete();
        }
        $student->delete();
        return redirect()->route('dashboard.admin.master-data.students.index')->with('success', 'Berhasil menghapus siswa.');
    }
}
