<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfilePicRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $user = Auth::user();

        if (! (Hash::check($old_password, $user->password))) {
            return redirect()->back()->with('error', 'Old password is wrong.');
        }

        if ($old_password == $new_password) {
            return redirect()->back()->with('error', 'New password cannot be same as old password.');
        }

        $user->update([
            'password' => Hash::make($new_password),
        ]);

        return redirect()->back()->with('success', 'Password changed successfully.');
    }
}
