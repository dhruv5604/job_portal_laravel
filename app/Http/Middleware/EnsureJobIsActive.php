<?php

namespace App\Http\Middleware;

use App\Models\Job;
use Closure;
use Illuminate\Http\Request;

class EnsureJobIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $job = $request->route('job') ?: $request->job_id;

        if (! ($job instanceof Job)) {
            $job = Job::where('id', $job)->first();
        }

        abort_if(! $job || $job->status !== 1, 404);

        $request->attributes->set('job', $job);

        return $next($request);
    }
}
