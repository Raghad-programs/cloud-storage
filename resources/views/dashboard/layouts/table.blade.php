@extends('dashboard.layouts.app')
@section("title", "Employees")  
@section('content')  

                <!-- Begin Page Content -->
               
    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Users Table</h6>
                        </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>email</th>
                                            <th>created_at</th>
                                            
                                        </tr>
                                    </thead>
                                      
                                    <tbody>
                                        @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
 
                                        </tr>
                                        @endforeach
                                    </tbody>
</table>
        </div>
    </div>
</div>

@endsection