<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminJobController;
use App\Http\Controllers\AdminJobApplicationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\SavedJobController;
use App\Http\Middleware\CheckIsAdmin;
use App\Http\Middleware\EnsureJobIsActive;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'jobs'])->name('jobs');
Route::get('/job-details/{job}', [JobController::class, 'jobDetails'])->name('jobDetails')->middleware(EnsureJobIsActive::class);

// Guest user routes
Route::middleware('guest')->prefix('account')->name('account.')->group(function () {
    Route::view('/register', 'front.account.registration')->name('register');
    Route::post('/process-register', [AccountController::class, 'processRegistration'])->name('processRegistration');
    Route::view('/login', 'front.account.login')->name('login');
    Route::post('/authenticate', [AccountController::class, 'authenticate'])->name('authenticate');
    Route::view('/forgot-password', view: 'front.account.forgot-password')->name('forgotPassword');
    Route::post('/process-forgot-password', [AccountController::class, 'processForgotPassword'])->name('processForgotPassword');
    Route::view('/reset-password/{token}', ' front.account.reset-password')->name('resetPassword');
    Route::post('/process-reset-password', [AccountController::class, 'processResetPassword'])->name('processResetPassword');
});

// Authenticated user routes
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::get('/logout', [AccountController::class, 'logout'])->name('logout');
    Route::resource('jobs', JobController::class)->except([
        'show',
    ]);
    Route::post('/update-profile/{user}', [AccountController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-profile-pic/{user}', [AccountController::class, 'updateProfilePic'])->name('updateProfilePic');
    Route::resource('saved-jobs', SavedJobController::class)
        ->only(['index', 'store', 'destroy']);
    Route::post('/change-password', [AccountController::class, 'changePassword'])->name('changePassword');
    Route::resource('job-applications', JobApplicationController::class)->only([
        'index', 'store', 'destroy',
    ]);
});

Route::middleware(['auth', CheckIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminUserController::class, 'dashboard'])->name('dashboard');
    Route::resource('user', AdminUserController::class)->only([
        'index', 'edit', 'update', 'destroy',
    ]);
    Route::resource('job', AdminJobController::class)->only([
        'index',
    Route::resource('job-application', AdminJobApplicationController::class)->only([
        'index', 'destroy',
    ]);
});
