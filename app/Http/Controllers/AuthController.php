<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\User;
use App\Models\MasterData\Student;

// Enums
use App\Enums\RoleEnum;

class AuthController extends Controller
{
    public function signup(Request $request): View | RedirectResponse
    {
        if ($request->isMethod('get')) {
            return view('pages.auth.signup');
        }
        $validated = $request->validate([
            'nisn' => ['required', 'digits:10'],
            'dob' => ['date'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);
        $student = Student::where('nisn', $validated['nisn'])->where('dob', $validated['dob'])->first();
        if (!$student) {
            return back()->withErrors('NISN atau Tanggal Lahir salah')->withInput($request->except('password'));
        }
        if ($student->user) {
            return back()->withErrors('Siswa sudah memiliki akun.')->withInput($request->except(['nisn', 'dob', 'password']));
        }
        unset($validated['nisn'], $validated['dob']);
        $validated['name'] = $student->name;
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = RoleEnum::STUDENT;
        $user = User::create($validated);
        $student->update([
            'user_id' => $user->id,
        ]);
        return redirect()->route('login')->with('success', 'Berhasil daftar, silakan masuk');
    }

    public function login(Request $request): View | RedirectResponse
    {
        if ($request->isMethod('get')) {
            return view('pages.auth.login');
        }
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'max:255'],
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.max' => 'Panjang email tidak boleh lebih dari :max karakter',
            'password.required' => 'Password harus diisi',
            'password.max' => 'Panjang password tidak boleh lebih dari :max karakter',
        ]);
        if (!Auth::attempt($validated)) {
            return back()->with('error', 'Email atau password salah')->withInput($request->except('password'));
        }
        $request->session()->regenerate();
        return redirect()->route('dashboard.' . $request->user()->role->value . '.index')->with('success', 'Berhasil masuk!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil keluar!');
    }
}
