@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        @include('front.layouts.nav-bar')
        <div class="row">
            <div class="col-lg-3">
                @if (Auth::user()->role == 'admin')
                @include('admin.sidebar')
                @else
                @include('front.account.sidebar')
                @endif
            </div>
            <div class="col-lg-9">
                @if (Session::has('success'))
                <div class="alert alert-success">
                    <p class="mb-0 pb-0">{{ Session::get('success') }}</p>
                </div>
                @endif
                <div class="card border-0 shadow mb-4">
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
                                        <x-error-message field="title" />
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">Select a Category</option>
                                            @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                            <option @selected($job->category_id == $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <x-error-message field="category_id" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                        <select name="job_type_id" id="job_type_id" class="form-select @error('job_type_id') is-invalid @enderror">
                                            <option value="">Select a Job Nature</option>
                                            @if ($jobTypes->isNotEmpty())
                                            @foreach ($jobTypes as $jobType)
                                            <option @selected($job->job_type_id == $jobType->id) value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <x-error-message field="job_type_id" />
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" value="{{ $job->vacancy }}" class="form-control @error('vacancy') is-invalid @enderror">
                                        <x-error-message field="vacancy" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Salary<span class="req">*</span></label>
                                        <input type="text" placeholder="Salary" id="salary" name="salary" value="{{ $job->salary }}" class="form-control @error('salary') is-invalid @enderror">
                                        <x-error-message field="salary" />
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <label for="" class="mb-2">Location<span class="req">*</span></label>
                                        <input type="text" placeholder="location" id="location" name="location" value="{{ $job->location }}" class="form-control @error('location') is-invalid @enderror">
                                        <x-error-message field="location" />
                                    </div>
                                </div>
                                @if (Auth::user()->role == 'admin')
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <div class="form-check">
                                            <input type="hidden" name="isFeatured" value="0">
                                            <input type="checkbox" id="isFeatured" name="isFeatured" value="1" class="form-check-input @error('isFeatured') is-invalid @enderror" {{ old('isFeatured', $job->isFeatured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isFeatured">
                                                Featured
                                            </label>
                                            <x-error-message field="isFeatured" />
                                        </div>
                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input type="radio"
                                                id="status-active"
                                                name="status"
                                                value="1"
                                                class="form-check-input @error('status') is-invalid @enderror"
                                                {{ old('status', $job->status) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status-active">
                                                Active
                                            </label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input type="radio"
                                                id="status-block"
                                                name="status"
                                                value="0"
                                                class="form-check-input @error('status') is-invalid @enderror"
                                                {{ old('status', $job->status) == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status-block">
                                                Block
                                            </label>
                                        </div>
                                        <x-error-message field="status" />
                                    </div>
                                </div>
                                @endif
                                <div class="mb-4">
                                    <label for="" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" cols="5" rows="5" placeholder="Description">{{ $job->description }}</textarea>
                                    <x-error-message field="description" />
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
                                        <option @selected($job->experience == 1) value="1">1 Year</option>
                                        @for ($i=2; $i<10; $i++)
                                            <option @selected($job->experience == $i) value="{{ $i }}">{{ $i }} Years</option>
                                            @endfor
                                            <option @selected($job->experience == '10_plus') value="10_plus">10+ Years</option>
                                    </select>
                                    <x-error-message field="experience" />
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
                                        <x-error-message field="company_name" />
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
    </div>
</section>
@endsection