<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\EmploymentRecordController;
use App\Http\Controllers\GovernmentController;

// ── Public Routes ────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ── Authentication Routes ────────────────────────────────────
Auth::routes(['verify' => true]);


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register']);


// ── Employee Routes ──────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    Route::get('/employee/dashboard', [DashboardController::class, 'employee'])
        ->name('employee.dashboard');

    Route::get('/get/employee/records', [EmployeeDashboardController::class, 'records'])
        ->name('employee.records.index');
    Route::get('/get/employee/record/{id}', [EmployeeDashboardController::class, 'showRecord'])
        ->name('employee.records.show');

    Route::get('/employee/claim', [EmployeeDashboardController::class, 'createClaim'])
        ->name('employee.claims.create');
    Route::post('/employee/claim', [EmployeeDashboardController::class, 'storeClaim'])
        ->name('employee.claim.store');

    Route::post('/employee/record/accept', [EmployeeDashboardController::class, 'acceptRecord'])
        ->name('employee.record.accept');

    Route::get('/employee/profile', [EmployeeDashboardController::class, 'showEmployee'])
        ->name('employee.profile');

    Route::get('/employee/feedback', [EmployeeDashboardController::class, 'showFeedback'])
        ->name('employee.feedback.index');
});

// ── Employee Search & Resource ───────────────────────────────
Route::get('/employees/search', [EmployeeController::class, 'search'])
    ->name('employees.search');

Route::resource('employees', EmployeeController::class);

// ── Employer Routes ──────────────────────────────────────────
Route::prefix('employer')->name('employer.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard',  [DashboardController::class, 'employer'])->name('dashboard');
    Route::get('/register',   [EmployerController::class, 'create'])->name('register');
    Route::post('/register',  [EmployerController::class, 'store'])->name('store');
    Route::get('/pending',    [EmployerController::class, 'pending'])->name('pending');

    // Employment management
    Route::post('/employment/report',         [EmployerController::class, 'reportEmployment'])->name('employment.report');
    Route::patch('/employment/{record}/exit', [EmployerController::class, 'reportExit'])->name('employment.exit');

    // Feedback
    Route::get('/feedback/{record}/create',  [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback/{record}',        [FeedbackController::class, 'store'])->name('feedback.store');

    // Verification portal
    Route::get('/verify',                    [VerificationController::class, 'index'])->name('verify.index');
    Route::post('/verify/search',            [VerificationController::class, 'search'])->name('verify.search');
    Route::get('/verify/profile/{employee}', [VerificationController::class, 'show'])->name('verify.profile');
});

// ── Admin Routes ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard',  [DashboardController::class, 'admin'])->name('dashboard');
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
    Route::get('/audit-log',  [AdminController::class, 'auditLog'])->name('audit-log');

    // Employer management
    Route::get('/employers',                     [AdminController::class, 'employers'])->name('employers.index');
    Route::get('/employers/{employer}',          [AdminController::class, 'showEmployer'])->name('employers.show');
    Route::patch('/employers/{employer}/verify', [AdminController::class, 'verifyEmployer'])->name('employers.verify');

    // Employee management
    Route::get('/employees',                     [AdminController::class, 'employees'])->name('employees.index');
    Route::patch('/employees/{employee}/verify', [AdminController::class, 'verifyEmployee'])->name('employees.verify');

    // Feedback moderation
    Route::get('/feedback',                          [AdminController::class, 'feedback'])->name('feedback.index');
    Route::patch('/feedback/{feedback}/moderate',    [AdminController::class, 'moderateFeedback'])->name('feedback.moderate');
});

Route::prefix('employees/{employee}')
    ->name('employment-records.')
    ->group(function () {
        Route::get(
            'employment-records',
            [EmploymentRecordController::class, 'index']
        )->name('index');

        Route::post(
            'employment-records',
            [EmploymentRecordController::class, 'store']
        )->name('store');

        Route::get(
            'employment-records/{employmentRecord}',
            [EmploymentRecordController::class, 'show']
        )->name('show');

        Route::get(
            'employment-records/{employmentRecord}/edit',
            [EmploymentRecordController::class, 'edit']
        )->name('edit');

        Route::put(
            'employment-records/{employmentRecord}',
            [EmploymentRecordController::class, 'update']
        )->name('update');

        Route::delete(
            'employment-records/{employmentRecord}',
            [EmploymentRecordController::class, 'destroy']
        )->name('destroy');
    });

// ── Government Routes ─────────────────────────────────────────
Route::prefix('gov')->name('gov.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [GovernmentController::class, 'dashboard'])->name('dashboard');

    // Employers
    Route::get('/employers',                   [GovernmentController::class, 'employers'])->name('employers.index');
    Route::post('/employers/{id}/verify',      [GovernmentController::class, 'verifyEmployer'])->name('employers.verify');
    Route::post('/employers/{id}/reject',      [GovernmentController::class, 'rejectEmployer'])->name('employers.reject');
    Route::post('/employers/{id}/suspend',     [GovernmentController::class, 'suspendEmployer'])->name('employers.suspend');

    // Employees
    Route::get('/employees',                   [GovernmentController::class, 'employees'])->name('employees.index');
    Route::get('/employees/{id}/history',      [GovernmentController::class, 'employeeHistory'])->name('employees.history');

    // Transfers
    Route::get('/transfers',                   [GovernmentController::class, 'transfers'])->name('transfers.index');
    Route::post('/transfers/{id}/approve',     [GovernmentController::class, 'approveTransfer'])->name('transfers.approve');
    Route::post('/transfers/{id}/reject',      [GovernmentController::class, 'rejectTransfer'])->name('transfers.reject');

    // Claims
    Route::get('/claims',                      [GovernmentController::class, 'claims'])->name('claims.index');
    Route::post('/claims/{id}/resolve',        [GovernmentController::class, 'resolveClaim'])->name('claims.resolve');
});
