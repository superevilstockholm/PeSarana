<?php

use Illuminate\Support\Facades\Route;

// Auth Controller
use App\Http\Controllers\AuthController;

Route::get('/', function () {

});

Route::middleware(['guest'])->group(function () {
    // Auth
    Route::match(['get', 'post'], 'signup', [AuthController::class, 'signup'])->name('signup');
    Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('login');
});

// Protected
Route::middleware(['auth'])->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    // Dashboard
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        // Admin
        Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {

        });
        // Student
        Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {

        });
    });
});
