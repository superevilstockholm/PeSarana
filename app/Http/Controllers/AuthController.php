<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function signup(Request $request)
    {

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
