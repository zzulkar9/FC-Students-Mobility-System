<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseHandbookController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () { 
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }

    $user = auth()->user();
    switch ($user->user_type) {
        case User::TYPE_UTM_STUDENT:
            return redirect()->route('dashboard-utm-student');
        case User::TYPE_OTHER_STUDENT:
            return redirect()->route('dashboard-other-student');
        case User::TYPE_ADMIN:
            return redirect()->route('dashboard-admin');
        case User::TYPE_TDA:
            return redirect()->route('dashboard-tda');
        case User::TYPE_PROGRAM_COORDINATOR:
            return redirect()->route('dashboard-pc');
        case User::TYPE_UTM_STAFF:
            return redirect()->route('dashboard-staff');
        default:
            return abort(403, 'Unauthorized');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard-utm-student', function () { return view('dashboard.utm-student'); })->name('dashboard-utm-student');
    Route::get('/dashboard-other-student', function () { return view('dashboard.other-student'); })->name('dashboard-other-student');
    Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('dashboard-admin');
    Route::get('/dashboard-tda', function () { return view('dashboard.tda'); })->name('dashboard-tda');
    Route::get('/dashboard-pc', function () { return view('dashboard.pc'); })->name('dashboard-pc');
    Route::get('/dashboard-staff', function () { return view('dashboard.staff'); })->name('dashboard-staff');

    // User management routes
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');

    // Protect the course handbook management route with a policy
    Route::get('/course-handbook', function () {
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isProgramCoordinator())) {
            return app(CourseHandbookController::class)->index();
        }
        abort(403);
    })->name('course-handbook.index');

    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Add additional authenticated routes as needed...
});

require __DIR__ . '/auth.php';
