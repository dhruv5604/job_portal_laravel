<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)->withCount(['jobs' => function ($query) {
            $query->where('status', 1);
        }])->inRandomOrder()->take(8)->get();
        $categoriesForSearch = Category::where('status', 1)->get();
        $featuredJobs = Job::where('isFeatured', 1)->where('status', 1)->inRandomOrder()->with('jobType')->take(6)->get();
        $latestJobs = Job::where('status', 1)->with('jobType')->latest()->take(6)->get();

        return view('front.home', compact('categories', 'featuredJobs', 'latestJobs', 'categoriesForSearch'));
    }
}
