<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\MasterData\Student;
use Illuminate\Http\RedirectResponse;

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
        $students = Student::with(['classroom', 'user'])->paginate($limit)->appends($request->except('page'));
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
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
