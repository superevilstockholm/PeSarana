<?php

namespace App\Http\Controllers\MasterData;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\Classroom;

class ClassroomController extends Controller
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
        $query = Classroom::query()->withCount('students');

        $allowed_types = [
            'name', 'date'
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

        $classrooms = $query->paginate($limit)->appends($request->except('page'));
        return view('pages.dashboard.admin.master-data.classroom.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'classrooms' => $classrooms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.dashboard.admin.master-data.classroom.create', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'unique:classrooms,name'],
        ]);
        Classroom::create($validated);
        return redirect()->route('dashboard.admin.master-data.classrooms.index')->with('success', 'Berhasil membuat kelas.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom): View
    {
        return view('pages.dashboard.admin.master-data.classroom.edit', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'classroom' => $classroom,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'unique:classrooms,name,' . $classroom->id],
        ]);
        $classroom->update($validated);
        return redirect()->route('dashboard.admin.master-data.classrooms.index')->with('success', 'berhasil mengubah kelas.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('dashboard.admin.master-data.classrooms.index')->with('success', 'Berhasil menghapus kelas.');
    }
}
