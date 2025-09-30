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
                <div class="card-body card-form">
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Job Applications</h3>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Job Title</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Employer</th>
                                        <th scope="col">Applied Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if ($jobApplications->isNotEmpty())
                                    @foreach ($jobApplications as $jobApplication)
                                    <tr class="active">
                                        <td>{{ $jobApplication->job->title }}</td>
                                        <td>{{ $jobApplication->user->name }}</td>
                                        <td>{{ $jobApplication->employer->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($jobApplication->created_at)->format('d M, Y') }}</td>
                                        <td>
                                            <div class="action-dots float-center">
                                                <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <form action="{{ route('admin.job-application.destroy', $jobApplication) }}" method="post" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fa fa-trash" aria-hidden="true"></i> Remove
                                                            </button>
                                                        </form>
                                                    </li>

                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {{ $jobApplications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection