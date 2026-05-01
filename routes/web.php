<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Livewire\HomePage;
use App\Livewire\PublicCatalog;
use App\Livewire\TeacherDirectory;
use App\Livewire\CourseManager;
use App\Livewire\StudentManager;
use App\Livewire\EnrollmentForm;
use App\Livewire\LessonViewer;

// Public Routes
Route::name('public.')->group(function () {
    Route::get('/', HomePage::class)->name('home');
    
    // Livewire Public Routes
    Route::get('/catalogo', PublicCatalog::class)->name('catalog');
    Route::get('/profesores', TeacherDirectory::class)->name('teachers');
});

// Dev Login Route (Temporary)
if (app()->environment('local')) {
    Route::get('/dev/login/{role}', function ($role) {
        $user = \App\Models\User::role($role)->first();
        if ($user) {
            auth()->login($user);
            return redirect('/dashboard');
        }
        return "No user found with role: " . $role;
    });
}

// Private Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Livewire Admin & User Routes
    Route::get('/admin/courses', CourseManager::class)->name('admin.courses');
    Route::get('/admin/students', StudentManager::class)->name('admin.students');
    Route::get('/cursos/{slug}/enroll', EnrollmentForm::class)->name('courses.enroll');
    Route::get('/cursos/{slug}', LessonViewer::class)->name('courses.show');
});

require __DIR__.'/settings.php';
