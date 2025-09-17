<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'front.home')->name('home');

// Guest user routes
Route::middleware('guest')->prefix('account')->name('account.')->group(function () {
    Route::view('/register', 'front.account.registration')->name('register');
    Route::post('/process-register', [AccountController::class, 'processRegistration'])->name('processRegistration');
    Route::view('/login', 'front.account.login')->name('login');
    Route::post('/authenticate', [AccountController::class, 'authenticate'])->name('authenticate');
});

// Authenticated user routes
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::view('/profile', 'front.account.profile')->name('profile');
    Route::get('/logout', [AccountController::class, 'logout'])->name('logout');
    Route::get('/create-job', [AccountController::class, 'createJob'])->name('createJob');
    Route::post('/save-job', [AccountController::class, 'saveJob'])->name('saveJob');
    Route::get('/my-jobs/{user}', [AccountController::class, 'myJobs'])->name('myJobs');
    Route::get('/my-jobs/edit/{job}', [AccountController::class, 'editJob'])->name('editJob');
    Route::post('update/{job}', [AccountController::class, 'updateJob'])->name('updateJob');
    Route::get('/deleteJob/{job}', [AccountController::class, 'deleteJob'])->name('deleteJob');
});
