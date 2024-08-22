@extends('dashboard.layouts.app')
@section("title", "Employees")  
@section('content')  
    <!-- Begin Page Content -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h3 class="m-0 font-weight-bold text-primary">@lang('strings.employees') {{auth()->user()->department->department}} </h3>
        <a href="{{ route('register') }}" class="btn btn-primary" data-toggle="tooltip" title="@lang('employees.register_employee')">
            <i class="fa fa-user-plus"></i>
        </a>
    </div>
</div>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <div class="d-flex align-items-center">
        <!-- Topbar Search -->
        <form class="d-none d-sm-inline-block form-inline ml-md-1 mb-3  navbar-search mt-2 search-bar" action="" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control bg-light border-0 small border border-bottom-primary" placeholder="@lang('employees.search_employee')" aria-label="Search" aria-describedby="basic-addon2" value="{{request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
        </div>
    </nav>

<style>
    .search-bar {
        width: 250px; /* Adjust this width as needed */
    }
</style>

<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>@lang('employees.first_name')</th>
                <th>@lang('employees.last_name')</th>
                <th>@lang('strings.department')</th>
                <th>@lang('strings.email')</th>
                <th>@lang('employees.created_at')</th>
                <th>@lang('employees.actions')</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            @if ($user->role_id == 2)
            <tr>
                <td><a href="{{ route('employee.profile', $user->id) }}">{{ $user->first_name }}</a></td>
                <td>{{ $user->last_name }}</a></td>

                <td>{{ $user->department->department }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : '-' }}</td>
                <td>
                    <button class="btn btn-danger btn-circle delete-button" data-toggle="modal" data-target="#deleteModal" data-id="{{ $user->id }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endif
            @empty
            <tr>
                <td colspan="5">No employees found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Delete modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('employees.confirm_deletion')</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">@lang('employees.delete_confirmation')</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">@lang('employees.cancel')</button>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">@lang('employees.delete')</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var userId = button.data('id'); // Extract info from data-* attributes
            var url = '{{ route("user.destroy", ":id") }}';
            url = url.replace(':id', userId);

            // Update the form action
            var form = $(this).find('form');
            form.attr('action', url);
        });
    });
    </script>

    <script>
        $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
