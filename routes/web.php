<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

});

// Protected
Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        // Admin
        Route::middleware(['role:admin'])->group(function () {

        });
        // Student
        Route::middleware(['role:student'])->group(function () {

        });
    });
});
