<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
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

    public function profile()
    {
        $id = Auth::user()->id;

        $user = User::find($id);

        return view('front.account.profile', compact('user'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $id = Auth::user()->id;

        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'designation' => $request->designation,
            'mobile' => $request->mobile,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('account.login');
    }
}
