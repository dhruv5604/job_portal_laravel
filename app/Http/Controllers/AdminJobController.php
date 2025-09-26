<?php

namespace App\Http\Controllers;

use App\Http\Requests\createJobRequest;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;

class AdminJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::with(['jobType', 'user'])->withCount('applications')->paginate(10);

        return view('admin.job.index', compact('jobs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();

        return view('admin.job.edit', compact('job', 'categories', 'jobTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(createJobRequest $request, Job $job)
    {
        $job->update($request->validated());

        return redirect()->back()->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->back()->with('success', 'Job deleted successfully.');
    }
}
