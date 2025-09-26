@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        @include('front.layouts.nav-bar')
        <div class="row">
            <div class="col-lg-3">
                @include('admin.sidebar')
            </div>
            <div class="col-lg-9">

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

                <div class="card border-0 shadow mb-4">
                    <div class="card-body dashboard text-center">
                        <p class="h2">Welcome Administrator!!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection