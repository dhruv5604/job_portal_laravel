@extends('front.layouts.app')

@section('main')
<section class="section-4 bg-2">
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('jobs') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container job_details_area">

        @if (Session::has('success'))
        <div class="alert alert-success">
            <p class="mb-0 pb-0">{{ Session::get('success') }}</p>
        </div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-danger">
            <p class="mb-0 pb-0">{{ Session::get('error') }}</p>
        </div>
        @endif
        <div class="row pb-5">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                <div class="jobs_conetent">
                                    <a href="#">
                                        <h4>{{ $job->title }}</h4>
                                    </a>
                                    <div class="links_locat d-flex align-items-center">
                                        <div class="location">
                                            <p> <i class="fa fa-map-marker"></i>{{ $job->location }}</p>
                                        </div>
                                        <div class="location">
                                            <p> <i class="fa fa-clock-o"></i>{{ $job->JobType->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jobs_right">
                                <div class="apply_now">
                                    <a class="heart_mark" href="#"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <div class="single_wrap">
                            <h4>Job description</h4>
                            {{ $job->description }}
                        </div>
                        <div class="single_wrap">
                            <h4>Responsibility</h4>
                            {{ $job->responsibility }}
                        </div>
                        <div class="single_wrap">
                            <h4>Qualifications</h4>
                            {{ $job->qualification }}
                        </div>
                        <div class="single_wrap">
                            <h4>Benefits</h4>
                            {{ $job->benefits }}
                        </div>
                        <div class="border-bottom"></div>
                        <div class="pt-3 text-end">
                            <form action="{{ route('account.saved-jobs.store') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="job_id" value="{{ $job->id }}">
                                <button type="submit" class="btn btn-primary"
                                    onclick="this.disabled=true;this.form.submit();">
                                    Save
                                </button>
                            </form>
                            <form action="{{ route('account.job-applications.store') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="job_id" value="{{ $job->id }}">
                                <button type="submit" class="btn btn-primary"
                                    onclick="this.disabled=true;this.form.submit();">
                                    Apply
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="job_summary">
                        <div class="summary_header pb-1 pt-4">
                            <h3>Job summary</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Published on: <span>{{ $job->created_at->format('d M Y') }}</span></li>
                                <li>Vacancy: <span>{{ $job->vacancy }}</span></li>
                                <li>Salary: <span>{{ $job->salary }}</span></li>
                                <li>Location: <span>{{ $job->location }}</span></li>
                                <li>Job Nature: <span>{{ $job->jobType->name }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 my-4">
                    <div class="job_summary">
                        <div class="summary_header pb-1 pt-4">
                            <h3>Company Details</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Name: <span>{{ $job->company_name }}</span></li>
                                <li>Location: <span>{{ $job->company_location }}</span></li>
                                <li>Website: <span><a href="{{ $job->company_website }}" target="_blank">{{ $job->company_website }}</a></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection