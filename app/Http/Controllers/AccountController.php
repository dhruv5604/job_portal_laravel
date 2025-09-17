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

    public function createJob()
    {
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        return view('front.account.job.create', compact('categories', 'jobTypes'));
    }

    public function saveJob(createJobRequest $request) 
    {
        Job::create([
            'title' => $request->title,
            'category_id' => $request->category,
            'job_type_id' => $request->jobType,
            'user_id' => Auth::user()->id,
            'vacancy' => $request->vacancy,
            'salary' => $request->salary,
            'location' => $request->location,
            'description' => $request->description,
            'benefits' => $request->benefits,
            'responsibility' => $request->responsibility,
            'qualifications' => $request->qualifications,
            'keywords' => $request->keywords,
            'experience' => $request->experience,
            'company_name' => $request->company_name,
            'company_location' => $request->company_location,
            'company_website' => $request->company_website,
        ]);

        return redirect()->route('account.myJobs', Auth::user())->with('success', 'Job created successfully.');
    }

    public function  myJobs(User $user)
    {
        $jobs = Job::where('user_id', $user->id)->paginate(10);

        return view('front.account.job.my-jobs', compact('jobs'));
    }

    public function editJob(Job $job)
    {
        if ($job->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'You are not authorized to edit this job.');
        }

        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        return view('front.account.job.edit', compact('job', 'categories', 'jobTypes'));
    }

    public function updateJob(createJobRequest $request, Job $job)
    {
        $job->update([
            'title' => $request->title,
            'category_id' => $request->category,
            'job_type_id' => $request->jobType,
            'user_id' => Auth::user()->id,
            'vacancy' => $request->vacancy,
            'salary' => $request->salary,
            'location' => $request->location,
            'description' => $request->description,
            'benefits' => $request->benefits,
            'responsibility' => $request->responsibility,
            'qualifications' => $request->qualifications,
            'keywords' => $request->keywords,
            'experience' => $request->experience,
            'company_name' => $request->company_name,
            'company_location' => $request->company_location,
            'company_website' => $request->company_website,
        ]);

        return redirect()->route('account.myJobs', Auth::user())->with('success', 'Job updated successfully.');
    }

    public function deleteJob(Job $job)
    {
        if ($job->user_id != Auth::user()->id) {
            return redirect()->back()->with('error', 'You are not authorized to delete this job.');
        }

        $job->delete();

        return redirect()->route('account.myJobs', Auth::user())->with('success', 'Job deleted successfully.');
    }
}
