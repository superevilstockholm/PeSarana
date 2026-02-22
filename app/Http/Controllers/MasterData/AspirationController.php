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
    public function show(Aspiration $aspiration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aspiration $aspiration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aspiration $aspiration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aspiration $aspiration)
    {
        //
    }
}
