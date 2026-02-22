<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\MasterData\Category;
use App\Models\MasterData\Aspiration;

// Enums
use App\Enums\AspirationStatusEnum;
use App\Enums\RoleEnum;

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
            'aspiration_images' => ['nullable', 'array'],
            'aspiration_images.*' => ['image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
        ]);
        $validated['status'] = AspirationStatusEnum::PENDING;
        $validated['student_id'] = $request->user()->student->id;
        $aspiration = Aspiration::create($validated);
        if ($request->hasFile('aspiration_images')) {
            foreach ($request->file('aspiration_images') as $image) {
                $path = $image->store('aspiration_images', 'public');
                $aspiration->aspiration_images()->create([
                    'image_path' => $path,
                ]);
            }
        }
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
            'aspiration' => $aspiration->load(['student', 'category', 'aspiration_feedbacks', 'aspiration_feedbacks.user']),
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
            'aspiration_images' => ['nullable', 'array'],
            'aspiration_images.*' => ['image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'delete_images' => ['nullable', 'array'],
            'delete_images.*' => ['exists:aspiration_images,id'],
        ]);
        $aspiration->update($validated);
        if (!empty($validated['delete_images'])) {
            $imagesToDelete = $aspiration->aspiration_images()
                ->whereIn('id', $validated['delete_images'])
                ->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }
        if ($request->hasFile('aspiration_images')) {
            foreach ($request->file('aspiration_images') as $image) {
                $path = $image->store('aspiration_images', 'public');
                $aspiration->aspiration_images()->create([
                    'image_path' => $path,
                ]);
            }
        }
        return redirect()->route('dashboard.student.aspiration.index')->with('success', 'Berhasil mengubah aspirasi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aspiration $aspiration, Request $request): RedirectResponse
    {
        if ($request->user()->role === RoleEnum::STUDENT && $request->user()->student->id !== $aspiration->student_id) {
            abort(403, 'Forbidden');
        }
        if ($aspiration->aspiration_images()->count() > 0) {
            foreach ($aspiration->images as $image) {
                Storage::disk('public')->delete($image->path);
            }
        }
        $aspiration->delete();
        return redirect()->route('dashboard.student.aspiration.index')->with('success', 'Berhasil menghapus aspirasi!');
    }
}
