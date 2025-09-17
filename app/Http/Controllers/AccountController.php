<?php

namespace App\Http\Controllers;

use App\Http\Requests\createJobRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function processRegistration(RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('account.login')->with('success', 'You have registered successfully.');

    }

    public function authenticate(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('account.profile');
        }

        return redirect()->back()
            ->with('error', 'Invalid credentials. Please try again.');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('account.login');
    }
}
