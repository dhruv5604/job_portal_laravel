<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
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
    Route::resource('job-applications', JobApplicationController::class)->only([
        'index', 'store', 'destroy',
    ]);
});
