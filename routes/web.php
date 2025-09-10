<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('front.home');
})->name('home');

Route::middleware('guest')->prefix('account')->name('account.')->group(function () {
    Route::get('/register', function () {
        return view('front.account.registration');
    })->name('register');
    Route::post('/process-register', [AccountController::class, 'processRegistration'])->name('processRegistration');
    Route::get('/login', function () {
        return view('front.account.login');
    })->name('login');
    Route::post('/authenticate', [AccountController::class, 'authenticate'])->name('authenticate');
});

// Authenticated user routes
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/profile', function () {
        return view('front.account.profile');
    })->name('profile');
    Route::get('/logout', [AccountController::class, 'logout'])->name('logout');
});
