@extends('dashboard.layouts.app')
@section("title", "Employees")  
@section('content')  
    <!-- Begin Page Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">{{auth()->user()->department->department}} employees</h3>
        </div>
        <div class="card-body">
            <form class="d-none d-sm-inline-block form-inline ml-md-1 mb-3  navbar-search mt-2" action="" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-0 small border border-bottom-primary" placeholder="Search for employee" aria-label="Search" aria-describedby="basic-addon2" value="{{request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>email</th>
                            <th>created_at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        @if ($user->role_id == 2)
                        <tr>
                            <td><a href="{{ route('show-employee', $user->id) }}">{{ $user->name }}</a></td>
                            <td>{{ $user->department->department }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '-' }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection