<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

// Enums
use App\Enums\RoleEnum;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        return view('pages.dashboard.profile.index', [
            'meta' => [
                'sidebarItems' => $user->role === RoleEnum::ADMIN
                    ? adminSidebarItems()
                    : studentSidebarItems(),
            ],
            'user' => $user,
        ]);
    }

    public function edit(Request $request): View | RedirectResponse
    {
        $user = $request->user();
        if ($request->isMethod('get')) {
            return view('pages.dashboard.profile.edit', [
                'meta' => [
                    'sidebarItems' => $user->role === RoleEnum::ADMIN
                        ? adminSidebarItems()
                        : studentSidebarItems(),
                ],
                'user' => $user,
            ]);
        }
        $validated = $request->validate([
            'profile_picture_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
            'delete_profile_picture_image' => ['nullable', 'boolean'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'old_password' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'max:255'],
        ]);
        if ($request->boolean('delete_profile_picture_image')) {
            if ($user->profile_picture_path) {
                Storage::disk('public')->delete($user->profile_picture_path);
            }
            $validated['profile_picture_path'] = null;
        }
        if ($request->hasFile('profile_picture_image')) {
            if ($user->profile_picture_path) {
                Storage::disk('public')->delete($user->profile_picture_path);
            }
            $validated['profile_picture_path'] = $request->file('profile_picture_image')->store('profile-pictures', 'public');
        }
        if ($validated['password']) {
            if (!Hash::check($validated['old_password'], $user->password)) {
                return back()->withErrors('Katasandi sebelumnya salah.')->withInput($request->except(['old_password', 'password']));
            }
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);
        return redirect()->route('dashboard.profile.index')->with('success', 'Berhasil mengubah profil.');
    }
}
