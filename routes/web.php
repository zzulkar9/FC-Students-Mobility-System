<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseHandbookController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ApplicationFormController;
use App\Http\Controllers\MobilityProgramController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Welcome Route
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [MobilityProgramController::class, 'index']);
Route::resource('mobility-programs', MobilityProgramController::class);

// Dashboard Route based on user type
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

// Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Routes
    Route::get('/dashboard-utm-student', [ApplicationFormController::class, 'indexForStudent'])->name('dashboard-utm-student')->middleware('auth');
    Route::get('/dashboard-other-student', function () {
        return view('dashboard.other-student');
    })->name('dashboard-other-student');
    Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('dashboard-admin');
    Route::get('/dashboard-tda', function () {
        return view('dashboard.tda');
    })->name('dashboard-tda');
    // Update this to the correct method if changed
    Route::get('/dashboard-pc', [ApplicationFormController::class, 'coordinatorIndex'])->name('dashboard-pc')->middleware('auth');

    Route::get('/dashboard-staff', function () {
        return view('dashboard.staff');
    })->name('dashboard-staff');

    // User Management Routes
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');

    // Course Handbook Route
    Route::get('/course-handbook', function (CourseHandbookController $controller) {
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isProgramCoordinator())) {
            $searchQuery = request('search', '');
            return $controller->index($searchQuery);
        }
        return abort(403);
    })->name('course-handbook.index')->middleware('auth');

    // Course Resource Routes
    Route::resource('courses', CourseController::class)->except(['index', 'show', 'edit', 'destroy'])->middleware('auth');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit')->middleware('auth');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show')->middleware('auth');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy')->middleware('auth');
    Route::post('/courses/storeForSemester', [CourseController::class, 'storeForSemester'])->name('courses.storeForSemester');
    Route::get('/courses/createForSemester/{intakeYear}/{intakeSemester}/{yearSemester}', [CourseController::class, 'createForSemester'])->name('courses.createForSemester');

    // ADVERTISE ROUTE
    Route::get('/mobility-programs/create', [MobilityProgramController::class, 'create'])->name('mobility-programs.create');
    Route::post('/mobility-programs', [MobilityProgramController::class, 'store'])->name('mobility-programs.store');


    // Application Form Routes
    Route::get('/application-form', [ApplicationFormController::class, 'index'])->name('application-form.index')->middleware('auth');
    Route::post('/application-form/submit', [ApplicationFormController::class, 'submit'])->name('application-form.submit')->middleware('auth');
    Route::get('/application-form/review', [ApplicationFormController::class, 'review'])->name('application-form.review');
    Route::get('/application-form/{applicationForm}/review', [ApplicationFormController::class, 'show'])->name('application-form.show')->middleware('auth');
    Route::patch('/application-form/{applicationForm}/update-all-notes', [ApplicationFormController::class, 'updateAllNotes'])->name('application-form.update-all-notes')->middleware('auth');
    Route::patch('/application-form-subjects/{id}/update-notes', [ApplicationFormController::class, 'updateNotes'])->name('application-form.update-notes')->middleware('auth');
    Route::get('/application-form/{applicationForm}/edit', [ApplicationFormController::class, 'edit'])->name('application-form.edit')->middleware(['auth']);
    Route::put('/application-form/{applicationForm}', [ApplicationFormController::class, 'update'])->name('application-form.update')->middleware('auth');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
