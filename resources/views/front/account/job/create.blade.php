@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        @include('front.layouts.nav-bar')
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                <form action="{{ route('account.jobs.store') }}" method="post" id="createJobForm" name="createJobForm">
                    @csrf
                    <div class="card border-0 shadow mb-4 ">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1">Job Details</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Title<span class="req">*</span></label>
                                    <input type="text" placeholder="Job Title" id="title" name="title" class="form-control @error('title') is-invalid @enderror">
                                    <x-error-message field="title" />
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Category<span class="req">*</span></label>
                                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">Select a Category</option>
                                        @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                        <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <x-error-message field="job_type_id" />
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                    <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control @error('vacancy') is-invalid @enderror">
                                    <x-error-message field="vacancy" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Salary<span class="req">*</span></label>
                                    <input type="text" placeholder="Salary" id="salary" name="salary" class="form-control @error('salary') is-invalid @enderror">
                                    <x-error-message field="salary" />
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location<span class="req">*</span></label>
                                    <input type="text" placeholder="location" id="location" name="location" class="form-control @error('location') is-invalid @enderror">
                                    <x-error-message field="location" />
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Description<span class="req">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" cols="5" rows="5" placeholder="Description"></textarea>
                                <x-error-message field="description" />
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Benefits</label>
                                <textarea class="form-control @error('benefits') is-invalid @enderror" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
                                <x-error-message field="benefits" />
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Responsibility</label>
                                <textarea class="form-control @error('responsibility') is-invalid @enderror" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility"></textarea>
                                <x-error-message field="responsibility" />
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Qualifications</label>
                                <textarea class="form-control @error('qualifications') is-invalid @enderror" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications"></textarea>
                                <x-error-message field="qualifications" />
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Experience<span class="req">*</span></label>
                                <select name="experience" id="experience" class="form-control @error('experience') is-invalid @enderror">
                                    <option value="">Select an Experience</option>
                                    <option value="1">1 Year</option>
                                    @for ($i=2; $i<10; $i++)
                                    <option value="{{ $i }}">{{ $i }} Years</option>
                                    @endfor
                                    <option value="10_plus">10+ Years</option>
                                </select>
                                <x-error-message field="experience" />
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Keywords</label>
                                <input type="text" placeholder="keywords" id="keywords" name="keywords" class="form-control @error('keywords') is-invalid @enderror">
                                <x-error-message field="keywords" />
                            </div>
                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Name<span class="req">*</span></label>
                                    <input type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control @error('company_name') is-invalid @enderror">
                                    <x-error-message field="company_name" />
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location</label>
                                    <input type="text" placeholder="Location" id="company_location" name="company_location" class="form-control @error('company_location') is-invalid @enderror">
                                    <x-error-message field="company_location" />
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Website</label>
                                <input type="text" placeholder="Website" id="company_website" name="company_website" class="form-control @error('company_website') is-invalid @enderror">
                                <x-error-message field="company_website" />
                            </div>
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Save Job</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection