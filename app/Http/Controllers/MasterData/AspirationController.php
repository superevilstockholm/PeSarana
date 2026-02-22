<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\Category;
use App\Models\MasterData\Aspiration;

// Enums
use App\Enums\AspirationStatusEnum;

class AspirationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user_role = $request->user()->role->value;
        $limit = (int) $request->query('limit', 10);
        if ($limit > 100) {
            $limit = 100;
        }
        $aspirations = Aspiration::with(['student', 'category'])->paginate($limit)->appends($request->except('page'));
        return view($user_role === 'admin'
            ? 'pages.dashboard.admin.master-data.aspiration.index'
            : 'pages.dashboard.student.aspiration.index', [
            'meta' => [
                'sidebarItems' => $user_role === 'admin'
                    ? adminSidebarItems()
                    : studentSidebarItems(),
            ],
            'aspirations' => $aspirations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('pages.dashboard.student.aspiration.create', [
            'meta' => [
                'sidebarItems' => studentSidebarItems(),
            ],
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);
        $validated['status'] = AspirationStatusEnum::PENDING;
        $validated['student_id'] = $request->user()->student->id;
        Aspiration::create($validated);
        return redirect()->route('dashboard.student.aspiration.index')->with('success', 'Berhasil membuat aspirasi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aspiration $aspiration, Request $request): View
    {
        $user_role = $request->user()->role->value;
        return view($user_role === 'admin'
            ? 'pages.dashboard.admin.master-data.aspiration.show'
            : 'pages.dashboard.student.aspiration.show', [
            'meta' => [
                'sidebarItems' => $user_role === 'admin'
                    ? adminSidebarItems()
                    : studentSidebarItems(),
            ],
            'aspiration' => $aspiration->load(['student', 'category', 'feedbacks', 'feedbacks.user']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aspiration $aspiration, Request $request): View | RedirectResponse
    {
        if ($request->user()->student->id !== $aspiration->student_id) {
            abort(403, 'Forbidden');
        }
        if ($aspiration->status !== AspirationStatusEnum::PENDING) {
            return redirect()->route('dashboard.student.aspiration.show', $aspiration)->with('error', 'Aspirasi tidak dapat diubah!');
        }
        $categories = Category::all();
        return view('pages.dashboard.student.aspiration.edit', [
            'meta' => [
                'sidebarItems' => studentSidebarItems(),
            ],
            'categories' => $categories,
            'aspiration' => $aspiration,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aspiration $aspiration)
    {
        if ($request->user()->student->id !== $aspiration->student_id) {
            abort(403, 'Forbidden');
        }
        if ($aspiration->status !== AspirationStatusEnum::PENDING) {
            return redirect()->route('dashboard.student.aspiration.show', $aspiration)->with('error', 'Aspirasi tidak dapat diubah!');
        }
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);
        $aspiration->update($validated);
        return redirect()->route('dashboard.student.aspiration.index')->with('success', 'Berhasil mengubah aspirasi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aspiration $aspiration): RedirectResponse
    {
        $aspiration->delete();
        return redirect()->route('dashboard.student.aspiration.index')->with('success', 'Berhasil menghapus aspirasi!');
    }
}
