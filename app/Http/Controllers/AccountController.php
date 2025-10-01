<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfilePicRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

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
        $user = Auth::user();

        return view('front.account.profile', compact('user'));
    }

    public function updateProfile(UpdateProfileRequest $request, User $user)
    {
        $user->update($request->only(['name', 'email', 'designation', 'mobile']));

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updateProfilePic(UpdateProfilePicRequest $request, User $user)
    {
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();

        $imageName = $user->id.'-'.time().'.'.$ext;

        // create a small thumbnail
        $path = $image->storeAs('profile_pic', $imageName, 'public');
        $manager = new ImageManager(Driver::class);
        $thumbnail = $manager->read($image->getRealPath())->cover(150, 150);
        $thumbPath = "profile_pic/thumb/{$imageName}";
        Storage::disk('public')->put($thumbPath, (string) $thumbnail->toPng());

        // delete old Profile pic
        if ($user->image) {
            Storage::disk('public')->delete("profile_pic/{$user->image}");
            Storage::disk('public')->delete("profile_pic/thumb/{$user->image}");
        }

        // Update user
        $user->update([
            'image' => $imageName,
        ]);

        return redirect()->back()->with('success', 'Profile picture updated successfully.');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('account.login');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password changed successfully.');
    }

    public function processForgotPassword(LoginRequest $request)
    {
        $token = Str::random(60);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $user = user::whereEmail($request->email)->first();

        $mailData = [
            'token' => $token,
            'userName' => $user->name,
        ];

        Mail::to($user->email)->send(new ResetPasswordMail($mailData));

        return redirect()->back()->with('success', 'Password reset link sent to your email.');
    }

    public function processResetPassword(ChangePasswordRequest $request)
    {
        $token = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if ($token == null) {
            return redirect()->route('account.forgotPassword')->with('error', 'Invalid or expired token.');
        }

        User::where('email', $token->email)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('account.login')->with('success', 'Password reset successfully please login.');
    }
}
