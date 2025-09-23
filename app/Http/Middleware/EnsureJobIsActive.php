<?php

namespace App\Http\Middleware;

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
        $job = $request->route('job');

        abort_if(! $job || $job->status !== 1, 404);

        return $next($request);
    }
}
