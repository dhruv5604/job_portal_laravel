@extends('front.layouts.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>
                    <form action="{{ route('account.processRegistration') }}" method="POST" name="registrationForm" id="registrationForm">
                        @csrf
                        <div class="mb-3">
                            <label class="mb-2">Name*</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter Name" value="{{ old('name') }}">
                            <x-error-message field="name" />
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Email*</label>
                            <input type="text" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter Email" value="{{ old('email') }}">
                            <x-error-message field="email" />
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Password*</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter Password">
                            <x-error-message field="password" />
                        </div>
                        <div class="mb-3">
                            <label class="mb-2">Confirm Password*</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Enter Confirm Password">
                            <x-error-message field="password_confirmation" />
                        </div>
                        <button class="btn btn-primary mt-2">Register</button>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <p>Have an account? <a href="{{ route('account.login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection