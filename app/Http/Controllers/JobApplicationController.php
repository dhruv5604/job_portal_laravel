<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobApplications = JobApplication::where('user_id', Auth::id())
            ->with([
                'job' => function ($q) {
                    $q->withCount('applications')
                        ->with('jobType');
                },
            ])
            ->paginate(10);

        return view('front.account.job.my-job-applications', compact('jobApplications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $job = Job::findOrFail($request->job_id);
        $employer_id = $job->user_id;

        if ($employer_id == Auth::id()) {
            return back()->with('error', 'You cannot apply to your own job.');
        }

        $alreadyApplied = JobApplication::where([
            'job_id' => $job->id,
            'user_id' => Auth::id(),
        ])->exists();

        if ($alreadyApplied) {
            return redirect()->back()->with('error', 'You have already applied to this job.');
        }

        JobApplication::create([
            'job_id' => $job->id,
            'user_id' => Auth::id(),
            'employer_id' => $employer_id,
            'applied_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Job applied successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobApplication $jobApplication)
    {
        abort_if($jobApplication->user_id !== Auth::id(), 403);
        $jobApplication->delete();

        return redirect()->back()->with('success', 'Job removed successfully.');
    }
}
