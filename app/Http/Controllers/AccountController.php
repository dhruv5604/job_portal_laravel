<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfilePicRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
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

    public function updateProfilePic(UpdateProfilePicRequest $request)
    {
        $id = Auth::user()->id;

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();

        $imageName = $id.'-'.time().'.'.$ext;
        $image->move(public_path('/profile_pic/'), $imageName);

        // create a small thumbnail
        $sourcePath = public_path('/profile_pic/'.$imageName);
        $manager = new ImageManager(Driver::class);
        $image = $manager->read($sourcePath);

        $image->cover(150, 150);
        $image->toPng()->save(public_path('/profile_pic/thumb/'.$imageName));

        // delete old Profile pic
        File::delete(public_path('/profile_pic/'.Auth::user()->image));
        File::delete(public_path('/profile_pic/thumb/'.Auth::user()->image));

        User::where('id', $id)->update([
            'image' => $imageName,
        ]);

        return redirect()->back()->with('success', 'Profile picture updated successfully.');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('account.login');
    }
}
