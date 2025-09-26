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
                @if (Session::has('success'))
                <div class="alert alert-success">
                    <p class="mb-0 pb-0">{{ Session::get('success') }}</p>
                </div>
                @endif
                <div class="card-body card-form">
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Jobs</h3>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Id</th>
                                        <th scope="col">Created by</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if ($jobs->isNotEmpty())
                                    @foreach ($jobs as $job)
                                    <tr class="active">
                                        <td>{{ $job->id }}</td>
                                        <td>
                                            <div class="job-name fw-500">{{ $job->title }}</div>
                                            <div class="info1">{{ $job->applications_count }} Applications</div>
                                        </td>
                                        <td>{{ $job->user->name }}</td>
                                        <td><div class="job-status text-capitalize">{{ $job->status == 1 ? 'active' : 'inactive' }}</div></td>
                                        <td>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</td>
                                        <td>
                                            <div class="action-dots float-center">
                                                <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('admin.job.edit', $job) }}"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                    <li>
                                                        <form action="{{ route('admin.job.destroy', $job) }}" method="post" style="display:inline;">
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
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection