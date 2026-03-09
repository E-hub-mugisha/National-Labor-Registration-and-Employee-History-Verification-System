<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AdminController;

// ── Public Routes ────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ── Authentication Routes ────────────────────────────────────
Auth::routes(['verify' => true]);

// ── Employee Routes ──────────────────────────────────────────
Route::prefix('employee')->name('employee.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard',         [EmployeeController::class, 'dashboard'])->name('dashboard');
    Route::get('/register',          [EmployeeController::class, 'create'])->name('register');
    Route::post('/register',         [EmployeeController::class, 'store'])->name('store');
    Route::get('/profile/edit',      [EmployeeController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',           [EmployeeController::class, 'update'])->name('profile.update');
    Route::post('/skills',           [EmployeeController::class, 'addSkill'])->name('skills.store');
    Route::delete('/skills/{skill}', [EmployeeController::class, 'deleteSkill'])->name('skills.destroy');
    Route::post('/qualifications',   [EmployeeController::class, 'addQualification'])->name('qualifications.store');
    Route::patch('/toggle-searchable', [EmployeeController::class, 'toggleSearchable'])->name('toggle-searchable');
    Route::get('/profile', [EmployeeController::class, 'profile'])->name('profile');

    // Feedback response
    Route::get('/feedback',                          [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback/{feedback}/respond',      [FeedbackController::class, 'respond'])->name('feedback.respond');
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
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
