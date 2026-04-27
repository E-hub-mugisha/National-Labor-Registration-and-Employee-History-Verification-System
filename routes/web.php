<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GovernmentController;

// ── Public Routes ────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ── Authentication Routes ────────────────────────────────────
Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->prefix('employees')->name('employees.')->group(function () {
 
    // Listing — /employees
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
 
    // Search — /employees/search
    Route::get('/search', [EmployeeController::class, 'search'])->name('search');
 
    // Register new employee — /employees/create + /employees
    Route::get('/create', [EmployeeController::class, 'create'])->name('create');
    Route::post('/', [EmployeeController::class, 'store'])->name('store');
 
    // Profile — /employees/{employee}
    Route::get('/{employee}', [EmployeeController::class, 'show'])->name('show');
 
    // Exit (end employment) — /employees/{employee}/exit
    Route::get('/{employee}/exit', [EmployeeController::class, 'exitForm'])->name('exit');
    Route::post('/{employee}/exit', [EmployeeController::class, 'recordExit'])->name('recordExit');
 
    // Transfer request — /employees/{employee}/transfer
    Route::post('/{employee}/transfer', [EmployeeController::class, 'requestTransfer'])->name('transfer');
 
});

// ── Employer Routes ──────────────────────────────────────────
Route::prefix('employer')->name('employer.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard',  [EmployerController::class, 'dashboard'])->name('dashboard');
    Route::get('/register',   [EmployerController::class, 'create'])->name('register');
    Route::post('/register',  [EmployerController::class, 'store'])->name('store');
    Route::get('/pending',    [EmployerController::class, 'pending'])->name('pending');

    // Employment management
    Route::post('/employment/report',          [EmployerController::class, 'reportEmployment'])->name('employment.report');
    Route::patch('/employment/{record}/exit',  [EmployerController::class, 'reportExit'])->name('employment.exit');

    // Feedback submission
    Route::get('/feedback/{record}/create',  [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback/{record}',        [FeedbackController::class, 'store'])->name('feedback.store');

    // Verification portal
    Route::get('/verify',                      [VerificationController::class, 'index'])->name('verify.index');
    Route::post('/verify/search',              [VerificationController::class, 'search'])->name('verify.search');
    Route::get('/verify/profile/{employee}',   [VerificationController::class, 'show'])->name('verify.profile');
});

// ── Admin Routes ─────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard',   [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/statistics',  [AdminController::class, 'statistics'])->name('statistics');
    Route::get('/audit-log',   [AdminController::class, 'auditLog'])->name('audit-log');

    // Employer management
    Route::get('/employers',                          [AdminController::class, 'employers'])->name('employers.index');
    Route::patch('/employers/{employer}/verify',      [AdminController::class, 'verifyEmployer'])->name('employers.verify');

    // Employee management
    Route::get('/employees',  [AdminController::class, 'employees'])->name('employees.index');
    Route::patch('/employees/{employee}/verify',        [AdminController::class, 'verifyEmployee'])->name('employees.verify');
    // Feedback moderation
    Route::get('/feedback',                           [AdminController::class, 'feedback'])->name('feedback.index');
    Route::patch('/feedback/{feedback}/moderate',     [AdminController::class, 'moderateFeedback'])->name('feedback.moderate');
});

Route::prefix('gov')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [GovernmentController::class, 'dashboard']);

    // Employers
    Route::get('/employers', [GovernmentController::class, 'employers']);
    Route::post('/employers/{id}/verify', [GovernmentController::class, 'verifyEmployer']);
    Route::post('/employers/{id}/reject', [GovernmentController::class, 'rejectEmployer']);
    Route::post('/employers/{id}/suspend', [GovernmentController::class, 'suspendEmployer']);

    // Employees
    Route::get('/employees', [GovernmentController::class, 'employees']);
    Route::get('/employees/{id}/history', [GovernmentController::class, 'employeeHistory']);

    // Transfers
    Route::get('/transfers', [GovernmentController::class, 'transfers']);
    Route::post('/transfers/{id}/approve', [GovernmentController::class, 'approveTransfer']);
    Route::post('/transfers/{id}/reject', [GovernmentController::class, 'rejectTransfer']);

    // Claims
    Route::get('/claims', [GovernmentController::class, 'claims']);
    Route::post('/claims/{id}/resolve', [GovernmentController::class, 'resolveClaim']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
