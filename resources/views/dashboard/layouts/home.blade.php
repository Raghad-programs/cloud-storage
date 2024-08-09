@extends('dashboard.layouts.app')
@section("title", "Dashboard")  
@section('content')  

<!-- Include the new JavaScript file -->

<!-- Pass the fileTypeDistribution data as JSON -->
<script id="fileTypeDistributionData" type="application/json">{!! json_encode($fileTypeDistribution) !!}</script>

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>



    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
     
            <!-- Dropdown - Messages -->
          

        <!-- Nav Item - Alerts -->
<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <span class="badge badge-danger badge-counter">{{ auth()->user()->unreadNotifications->count() }}</span>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
            Alerts Center
        </h6>
        @foreach(auth()->user()->unreadNotifications as $notification)
            <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">{{ $notification->created_at->format('F d, Y') }}</div>
                    <span class="font-weight-bold">{{ $notification->data['message'] }}</span>
                </div>
            </a>
        @endforeach
        <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
    </div>
</li>
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->name}}</span>
                <img class="img-profile rounded-circle" src="backend/img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/profile/{{auth()->user()->id}}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="{{route('profile.edit', auth()->user()->id)}}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content Row -->
   <div class="row">
    <!-- Total Documents Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Documents You
                            uploaded </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $DocumentsForUser }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-user-circle-o fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Documents(For Department)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $documentsPerDepartment }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-folder fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Documents (For Department) Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Documents(For Department)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $documentsPerDepartment }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-folder fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Storage Usage Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Storage Usage by you
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{ $userUsedStoragePercentage }}%</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: {{ $userUsedStoragePercentage }}%"
                                        aria-valuenow="{{ $userUsedStoragePercentage }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hdd fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Documents Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Documents</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalDocuments}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow mb-4" style="height: 100%;">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Document Upload Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-lg-5 mb-0">
            <div class="card shadow mb-4" style="height: 100%;">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">File Types</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Content Row -->
        <div class="row">
            <!-- Departments Card -->
            <div class="col-lg-7 mb-4">
                <div class="card shadow mb-4" style="width: 670px">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Departments</h6>
                    </div>
                    <div class="card-body" style="min-height: 200px;">
                        @foreach ($topDepartments as $department)
                            <h4 class="small font-weight-bold">{{ $department->department }} <span
                                    class="float-right">{{ $department->department_storages_count }}</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar {{ $department->department_storages_count <= 20 ? 'bg-danger' : ($department->department_storages_count <= 40 ? 'bg-warning' : ($department->department_storages_count <= 60 ? 'bg-primary' : ($department->department_storages_count <= 80 ? 'bg-info' : 'bg-success'))) }}"
                                    role="progressbar" style="width: {{ $department->department_storages_count }}%"
                                    aria-valuenow="{{ $department->department_storages_count }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Recent Files Card -->
            @if ($recentUpload)
                <div class="col-lg-5 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="height: 50px;">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Files</h6>
                        </div>
                        <div class="card-body"
                            style="display: flex; flex-direction: column; justify-content: space-between; overflow: auto;">
                            @if ($recentUpload->file_type == 3)
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4"
                                        src="{{ route('departmentStorage.view', $recentUpload) }}" alt="...">
                                </div>
                            @else
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" src="backend/img/undraw_posting_photo.svg"
                                        alt="...">
                                </div>
                            @endif
                            <div>
                                <h5>{{ $recentUpload->title }}</h5>
                                <p>{{ $recentUpload->description }}</p>
                            </div>
                            <div>
                                <a href="{{ route('departmentStorage.view', $recentUpload) }}" target="_blank"
                                    class="text-decoration-none text-primary">
                                    Browse more &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                    <div class="col-lg-5 mb-4">
                        <div class="card shadow mb-4" style="width: 450px; height: 150px;">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Recent Files</h6>
                            </div>
                            <div class="card-body" style="height: 100%; overflow-y: auto;">
                                <p>No recent files to display.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
    </div>



</div>
<!-- /.container-fluid -->


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
<script>
    var fileTypeLabels = @json($fileTypeDistribution->keys());
    var fileTypeData = @json($fileTypeDistribution->values());
    var monthlyLabels = @json($monthlyUploads->pluck('month'));
    var monthlyData = @json($monthlyUploads->pluck('count'));

</script>