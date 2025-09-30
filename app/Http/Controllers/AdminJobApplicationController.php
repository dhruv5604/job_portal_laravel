<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;

class AdminJobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobApplications = JobApplication::latest()->with(['job', 'user', 'employer'])->paginate(10);

        return view('admin.job-application.index', compact('jobApplications'));
    }

    public function destroy(JobApplication $jobApplication)
    {
        $jobApplication->delete();

        return redirect()->back()->with('success', 'Job application deleted successfully.');
    }
}
