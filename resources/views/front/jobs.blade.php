@extends('front.layouts.app')

@section('main')
<section class="section-3 py-5 bg-2 ">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 ">
                <h2>Find Jobs</h2>
            </div>
        </div>
        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <form action="{{ route('jobs') }}" method="get" name="searchForm" id="searchForm">
                    <div class="card border-0 shadow p-4">
                        <div class="mb-4">
                            <h2>Keywords</h2>
                            <input type="text" value="{{ Request::get('keyword') }}" name="keyword" id="keyword" placeholder="Keywords" class="form-control">
                        </div>
                        <div class="mb-4">
                            <h2>Location</h2>
                            <input type="text" value="{{ Request::get('location') }}" name="location" id="location" placeholder="Location" class="form-control">
                        </div>
                        <div class="mb-4">
                            <h2>Category</h2>
                            <select name="category" id="category" class="form-control">
                                <option value="">Select a Category</option>
                                @if ($categories->isNotEmpty())
                                @foreach ($categories as $category)
                                <option @selected(Request::get('category') == $category->id) value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-4">
                            <h2>Job Type</h2>
                            @if ($jobTypes->isNotEmpty())
                            @foreach ($jobTypes as $jobType)
                            <div class="form-check mb-2">
                                <input class="form-check-input " name="job_type[]" type="checkbox" value="{{ $jobType->id }}" id="job-type-{{ $jobType->id }}" @checked(in_array($jobType->id, (array) Request::get('job_type', [])))>
                                <label class="form-check-label " for="job-type-{{ $jobType->id }}">{{ $jobType->name }}</label>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="mb-4">
                            <h2>Experience</h2>
                            <select name="experience" id="experience" class="form-control">
                                <option value="">Select an Experience</option>
                                <option value="1" @selected(Request::get('experience') == 1)>1 Year</option>
                                @for ($i=2; $i<10; $i++)
                                    <option value="{{ $i }}" @selected(Request::get('experience') == $i)>{{ $i }} Years</option>
                                @endfor
                                <option value="10_plus" @selected(Request::get('experience') == '10_plus')>10+ Years</option>
                            </select>   
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('jobs') }}" class="btn btn-secondary mt-3">Reset</a>
                    </div>
                </form>
            </div>
            <div class="col-md-8 col-lg-9 ">
                <div class="job_listing_area">
                    <div class="job_lists">
                        <div class="row">
                            @if ($jobs->isNotEmpty())
                            @foreach ($jobs as $job)
                            <div class="col-md-4">
                                <div class="card border-0 p-3 shadow mb-4">
                                    <div class="card-body">
                                        <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->title }}</h3>
                                        <p>{{ Str::words($job->description, 10) }}</p>
                                        <div class="bg-light p-3 border">
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                <span class="ps-1">{{ $job->location }}</span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                <span class="ps-1">{{ $job->jobType->name }}</span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                <span class="ps-1">{{ $job->salary }}</span>
                                            </p>
                                        </div>
                                        <div class="d-grid mt-3">
                                            <a href="{{ route('jobDetails', $job) }}" class="btn btn-primary btn-lg">Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</section>
@endsection