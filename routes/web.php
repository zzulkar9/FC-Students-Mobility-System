<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseHandbookController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ApplicationFormController;
use App\Http\Controllers\MobilityProgramController;
use App\Http\Controllers\StudyPlanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CreditTransferController;
use App\Http\Controllers\CreditCalculationController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\InboundStudentController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Welcome Route
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [MobilityProgramController::class, 'index'])->name('welcome');
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
        case User::TYPE_AA:
            return redirect()->route('dashboard-aa');
        default:
            return abort(403, 'Unauthorized');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Routes
    // Route::get('/dashboard-utm-student', [ApplicationFormController::class, 'indexForStudent'])->name('dashboard-utm-student')->middleware('auth');
    // Route::get('/dashboard-other-student', function () {return view('dashboard.other-student');})->name('dashboard-other-student');
    Route::get('/dashboard-utm-student', [DashboardController::class, 'indexForStudent'])->name('dashboard-utm-student')->middleware('auth');
    Route::get('/dashboard-admin', [DashboardController::class, 'indexForAdmin'])->name('dashboard-admin');
    Route::get('/dashboard-tda', [DashboardController::class, 'indexForTDA'])->name('dashboard-tda')->middleware('auth');
    Route::get('/dashboard-pc', [DashboardController::class, 'indexForPC'])->name('dashboard-pc')->middleware('auth');
    Route::get('/dashboard-staff', [DashboardController::class, 'indexForStaff'])->name('dashboard-staff')->middleware('auth');
    Route::get('/dashboard-aa', [DashboardController::class, 'indexForAA'])->name('dashboard-aa')->middleware('auth');

    // User Management Routes
    Route::get('/users-list', [AdminController::class, 'userListIndex'])->name('users.users-list');
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
    Route::get('/full-course-handbook', [CourseHandbookController::class, 'FullHandbookIndex'])->name('course-handbook.full-handbook-index')->middleware('auth');

    // Course Resource Routes
    Route::resource('courses', CourseController::class)->except(['index', 'show', 'edit', 'destroy'])->middleware('auth');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit')->middleware('auth');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show')->middleware('auth');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy')->middleware('auth');
    Route::post('/courses/storeForSemester', [CourseController::class, 'storeForSemester'])->name('courses.storeForSemester');
    Route::get('/courses/createForSemester/{intakeYear}/{intakeSemester}/{yearSemester}', [CourseController::class, 'createForSemester'])->name('courses.createForSemester');
    Route::get('/courses/editForSemester/{intakeYear}/{intakeSemester}/{yearSemester}', [CourseController::class, 'editForSemester'])->name('courses.editForSemester')->middleware('auth');
    Route::post('/courses/updateForSemester', [CourseController::class, 'updateForSemester'])->name('courses.updateForSemester')->middleware('auth');
    Route::post('/set-target-credits', [CourseController::class, 'setTargetCredits'])->name('courses.setTargetCredits')->middleware('auth');

    // SEMESTER NOTE
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store')->middleware('auth');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update')->middleware('auth');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy')->middleware('auth');

    // ADVERTISE ROUTE
    Route::get('/mobility-programs', [MobilityProgramController::class, 'Programindex'])->name('mobility-programs.Programindex');
    Route::get('/mobility-programs/create', [MobilityProgramController::class, 'create'])->name('mobility-programs.create');
    Route::post('/mobility-programs', [MobilityProgramController::class, 'store'])->name('mobility-programs.store');
    Route::get('/mobility-programs/{program}/edit', [MobilityProgramController::class, 'edit'])->name('mobility-programs.edit');
    Route::put('/mobility-programs/{program}', [MobilityProgramController::class, 'update'])->name('mobility-programs.update');
    Route::get('/mobility-programs/{program}', [MobilityProgramController::class, 'show'])->name('mobility-programs.show');
    Route::delete('mobility-programs/{id}', [MobilityProgramController::class, 'destroy'])->name('mobility-programs.destroy');

    //STUDY PLANS
    Route::get('/study-plans', [StudyPlanController::class, 'index'])->name('study-plans.index');
    Route::post('/study-plans/update', [StudyPlanController::class, 'update'])->name('study-plans.update');
    Route::get('/study-plans/review/{user}', [StudyPlanController::class, 'review'])->name('study-plans.review');
    Route::post('/study-plans/review/{userId}/save-remarks', [StudyPlanController::class, 'saveRemarks'])->name('study-plans.save-remarks');

    // REAL CALCULATE CREDIT
    Route::get('/calculate-credits', [CreditCalculationController::class, 'calculateAndShowCredits'])->name('credits.calculate');
    Route::get('/credits', [CreditCalculationController::class, 'index'])->name('credits.index');
    Route::patch('/credits/{applicationForm}', [CreditCalculationController::class, 'updateCredits'])->name('credits.update');


    // INBOUND TIMETABLE
    Route::get('/timetables/upload', [TimetableController::class, 'create'])->name('timetables.create');
    Route::post('/timetables', [TimetableController::class, 'store'])->name('timetables.store');
    Route::get('/timetables', [TimetableController::class, 'index'])->name('timetables.index');
    Route::get('/timetables/show', [TimetableController::class, 'show'])->name('timetables.show');
    Route::post('/timetables/save', [TimetableController::class, 'saveAll'])->name('timetables.saveAll');

    // INBOUND STUDENT LIST
    Route::get('/inbound-students', [TimetableController::class, 'listInboundStudents'])->name('inbound-students.list');
    Route::get('/timetables/{student}/edit', [TimetableController::class, 'edit'])->name('inbound-students.edit');
    Route::put('/timetables/{student}', [TimetableController::class, 'update'])->name('inbound-students.update');
    Route::delete('/inbound-students/{id}', [TimetableController::class, 'deleteInboundStudent'])->name('inbound-students.delete');
    Route::get('/inbound-students/{student}/export', [TimetableController::class, 'exportStudent'])->name('inbound-students.export');
    Route::get('/inbound-students-list', [TimetableController::class, 'listInboundStudents'])->name('inbound-students.students-list');
    Route::get('/inbound-course-list', [TimetableController::class, 'listInboundCourses'])->name('inbound-students.course-list');

    // INBOUND COURSE
    Route::resource('timetables', TimetableController::class);
    Route::put('timetables/updateCourse/{id}', [TimetableController::class, 'updateCourse'])->name('timetables.updateCourse');
    Route::get('timetables/{id}/editCourse', [TimetableController::class, 'editCourse'])->name('timetables.editCourse');


    // Application Form Routes
    Route::get('/application-form', [ApplicationFormController::class, 'index'])->name('application-form.index')->middleware('auth');
    Route::post('/application-form/submit', [ApplicationFormController::class, 'submit'])->name('application-form.submit')->middleware('auth');
    Route::get('/application-form/review', [ApplicationFormController::class, 'review'])->name('application-form.review');
    Route::get('/application-form/{applicationForm}/review', [ApplicationFormController::class, 'show'])->name('application-form.show')->middleware('auth');
    Route::patch('/application-form/{applicationForm}/update-all-notes', [ApplicationFormController::class, 'updateAllNotes'])->name('application-form.update-all-notes')->middleware('auth');
    Route::patch('/application-form-subjects/{id}/update-notes', [ApplicationFormController::class, 'updateNotes'])->name('application-form.update-notes')->middleware('auth');
    Route::get('/application-form/{applicationForm}/edit', [ApplicationFormController::class, 'edit'])->name('application-form.edit')->middleware(['auth']);
    Route::put('/application-form/{applicationForm}', [ApplicationFormController::class, 'update'])->name('application-form.update')->middleware('auth');
    Route::post('application-form/{id}/comment', [ApplicationFormController::class, 'storeComment'])->name('application-form.comment.store');
    Route::patch('/application-form/{id}/approval-update', [ApplicationFormController::class, 'ApprovalUpdate'])->name('application-form.ApprovalUpdate');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
