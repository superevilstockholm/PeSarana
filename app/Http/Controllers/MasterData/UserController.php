<?php

namespace App\Http\Controllers\MasterData;

use App\Enums\RoleEnum;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\User;
use App\Models\MasterData\Student;

class UserController extends Controller
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
        $users = User::paginate($limit)->appends($request->except('page'));
        return view('pages.dashboard.admin.master-data.user.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $students = Student::whereNull('user_id')->get();
        return view('pages.dashboard.admin.master-data.user.create', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'students' => $students,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:admin,student'],
            'name' => ['nullable', 'required_if:role,admin', 'string', 'max:255'],
            'student_id' => ['nullable', 'required_if:role,student', 'exists:students,id'],
            'profile_picture_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
        ]);
        if ($validated['role'] === 'student') {
            $student = Student::where('id', $validated['student_id'])->first();
            $validated['name'] = $student->name;
        }
        $validated['password'] = Hash::make($validated['password']);
        if ($request->hasFile('profile_picture_image')) {
            $validated['profile_picture_path'] = $request->file('profile_picture_image')->store('profile-picture', 'public');
        }
        unset($validated['profile_picture_image']);
        $user = User::create($validated);
        if ($validated['role'] === 'student') {
            $student->update([
                'user_id' => $user->id,
            ]);
        }
        return redirect()->route('dashboard.admin.master-data.users.index')->with('success', 'Berhasil membuat pengguna.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('pages.dashboard.admin.master-data.user.show', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'user' => $user->load(['student'])->loadCount(['aspiration_feedbacks']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $students = $user->role === RoleEnum::STUDENT
            ? Student::whereNull('user_id')->orWhere('id', $user->student->id)->get()
            : Student::whereNull('user_id')->get();
        return view('pages.dashboard.admin.master-data.user.edit', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'students' => $students,
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:admin,student'],
            'name' => ['nullable', 'required_if:role,admin', 'string', 'max:255'],
            'student_id' => ['nullable', 'required_if:role,student', 'exists:students,id'],
        ]);
        if ($user->role === RoleEnum::STUDENT) {
            $user->student->update([
                'user_id' => null,
            ]);
        }
        if ($validated['role'] === 'student') {
            $student = Student::where('id', $validated['student_id'])->first();
            $validated['name'] = $student->name;
        }
        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);
        if ($validated['role'] === 'student') {
            $student->update([
                'user_id' => $user->id,
            ]);
        }
        return redirect()->route('dashboard.admin.master-data.users.index')->with('success', 'Berhasil mengubah pengguna.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->role === RoleEnum::STUDENT) {
            $user->student->update([
                'user_id' => null,
            ]);
        }
        $user->delete();
        return redirect()->route('dashboard.admin.master-data.users.index')->with('success', 'Berhasil menghapus pengguna.');
    }
}
