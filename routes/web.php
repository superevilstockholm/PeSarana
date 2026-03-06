<?php

use Illuminate\Support\Facades\Route;

// Home Controller
use App\Http\Controllers\HomeController;

// Auth Controller
use App\Http\Controllers\AuthController;

// Dashboard Controller
use App\Http\Controllers\DashboardController;

// Notification Controller
use App\Http\Controllers\NotificationController;

// Master Data Controllers
use App\Http\Controllers\MasterData\UserController;
use App\Http\Controllers\MasterData\StudentController;
use App\Http\Controllers\MasterData\CategoryController;
use App\Http\Controllers\MasterData\ClassroomController;
use App\Http\Controllers\MasterData\AspirationController;
use App\Http\Controllers\MasterData\AspirationFeedbackController;

Route::get('/', [HomeController::class, 'index'])->name('index');

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
            Route::get('/', [DashboardController::class, 'admin_dashboard'])->name('index');
            Route::resource('notifications', NotificationController::class)->parameters([
                'notifications' => 'notification'
            ])->only(['index', 'show', 'destroy']);
            // Master Data
            Route::prefix('master-data')->name('master-data.')->group(function () {
                Route::resource('classrooms', ClassroomController::class)->parameters([
                    'classrooms' => 'classroom',
                ])->except(['show']);
                Route::resource('categories', CategoryController::class)->parameters([
                    'categories' => 'category',
                ])->except(['show']);
                Route::resource('students', StudentController::class)->parameters([
                    'students' => 'student',
                ]);
                Route::resource('users', UserController::class)->parameters([
                    'users' => 'user',
                ]);
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
            Route::get('/', [DashboardController::class, 'student_dashboard'])->name('index');
            Route::resource('aspirations', AspirationController::class)->parameters([
                'aspirations' => 'aspiration'
            ]);
            Route::resource('notifications', NotificationController::class)->parameters([
                'notifications' => 'notification'
            ])->only(['index', 'show', 'destroy']);
        });
    });
});
