<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

// Public Routes
Route::name('public.')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canRegister' => Features::enabled(Features::registration()),
        ]);
    })->name('home');
    
    // Future: Catalog, Contact
    // Route::get('/courses', [PublicCourseController::class, 'index'])->name('courses.index');
});

// Private Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Future routes will be organized by prefix
    // Route::prefix('courses')->name('courses.')->group(function () { ... });
});

require __DIR__.'/settings.php';
