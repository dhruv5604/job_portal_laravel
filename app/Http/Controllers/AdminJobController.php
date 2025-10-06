<?php

namespace App\Http\Controllers;

use App\Models\Job;

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
}
