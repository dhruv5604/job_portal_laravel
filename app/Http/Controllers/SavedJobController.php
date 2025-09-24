<?php

namespace App\Http\Controllers;

use App\Http\Middleware\EnsureJobIsActive;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedJobController extends Controller
{
    public function __construct()
    {
        $this->middleware(EnsureJobIsActive::class)->only('store', 'destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $savedJobs = SavedJob::where('user_id', Auth::id())->with('job')->paginate(10);

        return view('front.account.job.saved-job', compact('savedJobs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $job = $request->attributes->get('job');

        SavedJob::create([
            'user_id' => Auth::id(),
            'job_id' => $job->id,
        ]);

        return redirect()->back()->with('success', 'Job saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavedJob $savedJob)
    {
        abort_if($savedJob->user_id !== Auth::id(), 403);
        $savedJob->delete();

        return redirect()->back()->with('success', 'Saved Job removed successfully.');
    }
}
