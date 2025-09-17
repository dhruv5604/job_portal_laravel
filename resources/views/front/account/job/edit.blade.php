@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                <form action="{{ route('account.jobs.update', $job) }}" method="post" id="editJobForm" name="editJobForm">
                    @csrf
                    @method('PUT')
                    <div class="card border-0 shadow mb-4 ">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1">Edit Job Details</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Title<span class="req">*</span></label>
                                    <input type="text" value="{{ $job->title }}" placeholder="Job Title" id="title" name="title" class="form-control @error('title') is-invalid @enderror">
                                    @error('title')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Category<span class="req">*</span></label>
                                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                        <option value="">Select a Category</option>
                                        @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                        <option {{ $job->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('category')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                    <select name="jobType" id="jobType" class="form-select @error('jobType') is-invalid @enderror">
                                        <option value="">Select a Job Nature</option>
                                        @if ($jobTypes->isNotEmpty())
                                        @foreach ($jobTypes as $jobType)
                                        <option {{ $job->job_type_id == $jobType->id ? 'selected' : '' }} value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('jobType')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                    <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" value="{{ $job->vacancy }}" class="form-control @error('vacancy') is-invalid @enderror">
                                    @error('vacancy')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Salary<span class="req">*</span></label>
                                    <input type="text" placeholder="Salary" id="salary" name="salary" value="{{ $job->salary }}" class="form-control @error('salary') is-invalid @enderror">
                                    @error('salary')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location<span class="req">*</span></label>
                                    <input type="text" placeholder="location" id="location" name="location" value="{{ $job->location }}" class="form-control @error('location') is-invalid @enderror">
                                    @error('location')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Description<span class="req">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" cols="5" rows="5" placeholder="Description">{{ $job->description }}</textarea>
                                @error('description')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Benefits</label>
                                <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ $job->benefits }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Responsibility</label>
                                <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Qualifications</label>
                                <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{ $job->qualifications }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Experience<span class="req">*</span></label>
                                <select name="experience" id="experience" class="form-control @error('experience') is-invalid @enderror">
                                    <option value="">Select an Experience</option>
                                    <option {{ $job->experience == 1 ? 'selected' : '' }} value="1">1 Year</option>
                                    @for ($i=2; $i<10; $i++)
                                    <option {{ $job->experience == $i ? 'selected' : '' }} value="{{ $i }}">{{ $i }} Years</option>
                                    @endfor
                                    <option {{ $job->experience == '10_plus' ? 'selected' : '' }} value="10_plus">10+ Years</option>
                                </select>
                                @error('experience')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Keywords</label>
                                <input type="text" placeholder="keywords" id="keywords" value="{{ $job->keywords }}" name="keywords" class="form-control">
                            </div>
                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Name<span class="req">*</span></label>
                                    <input type="text" placeholder="Company Name" id="company_name" name="company_name" value="{{ $job->company_name }}" class="form-control @error('company_name') is-invalid @enderror">
                                    @error('company_name')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location</label>
                                    <input type="text" placeholder="Location" id="company_location" value="{{ $job->company_location }}" name="company_location" class="form-control">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Website</label>
                                <input type="text" placeholder="Website" id="company_website" value="{{ $job->company_website }}" name="company_website" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update Job</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection