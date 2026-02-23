<?php

use Illuminate\Support\Facades\Route;

// Auth Controller
use App\Http\Controllers\AuthController;

// Master Data Controllers
use App\Http\Controllers\MasterData\ClassroomController;
use App\Http\Controllers\MasterData\AspirationController;
use App\Http\Controllers\MasterData\AspirationFeedbackController;

Route::get('/', function () {
    return view('pages.index');
})->name('index');

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
            Route::get('/', function () {
                return view('pages.dashboard.admin.index', [
                    'meta' => [
                        'sidebarItems' => adminSidebarItems(),
                    ]
                ]);
            })->name('index');
            // Master Data
            Route::prefix('master-data')->name('master-data.')->group(function () {
                Route::resource('classrooms', ClassroomController::class)->parameters([
                    'classrooms' => 'classroom',
                ])->except(['show']);
                Route::resource('aspirations', AspirationController::class)->parameters([
                    'aspirations' => 'aspiration'
                ])->only(['index', 'show', 'destroy']);
                Route::resource('aspiration-feedbacks', AspirationFeedbackController::class)->parameters([
                    'aspiration-feedbacks' => 'aspirationFeedback'
                ])->only(['store', 'update', 'destroy']);
            });
        });
        // Student
        Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
            Route::get('/', function () {
                return view('pages.dashboard.student.index', [
                    'meta' => [
                        'sidebarItems' => studentSidebarItems(),
                    ]
                ]);
            })->name('index');
            Route::resource('aspirations', AspirationController::class)->parameters([
                'aspirations' => 'aspiration'
            ]);
        });
    });
});
