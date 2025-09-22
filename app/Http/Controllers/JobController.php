<?php

namespace App\Http\Controllers;

use App\Http\Requests\createJobRequest;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::where('user_id', Auth::id())
            ->with('jobType')
            ->paginate(10);

        return view('front.account.job.my-jobs', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();

        return view('front.account.job.create', compact('categories', 'jobTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(createJobRequest $request)
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

        return redirect()->route('account.jobs.index')
            ->with('success', 'Job created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JOb $job)
    {
        $this->authorizeOwner($job);

        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();

        return view('front.account.job.edit', compact('job', 'categories', 'jobTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(createJobRequest $request, Job $job)
    {
        $this->authorizeOwner($job);
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

        return redirect()->route('account.jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $this->authorizeOwner($job);
        $job->delete();

        return redirect()->route('account.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }

    public function jobs(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();
        $jobs = Job::where('status', 1);

        if (! empty($request->keyword)) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->keyword.'%')
                    ->orWhere('keywords', 'like', '%'.$request->keyword.'%');
            });
        }

        if (! empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        if (! empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        if (! empty($request->job_type)) {
            $jobs = $jobs->whereIn('job_type_id', $request->job_type);
        }

        if (! empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }

        $jobs = $jobs->with('JobType')->latest()->paginate(9);

        return view('front.jobs', compact('categories', 'jobTypes', 'jobs'));
    }

    public function jobDetails(Job $job)
    {
        abort_unless($job->status == 1, 404);
        $job->load(['jobType', 'category']);

        return view('front.job-details', compact('job'));
    }

    private function authorizeOwner(Job $job)
    {
        abort_unless($job->user_id === Auth::id(), 403);
    }
}
