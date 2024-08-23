<?php
$auto = app()->getLocale() == 'ar' ? 'mr-auto' :'ml-auto';
?>


@extends('dashboard.layouts.app')
@section("title", "Dashboard")  
@section('content')  

<!-- Include the new JavaScript file -->

<!-- Pass the fileTypeDistribution data as JSON -->
<script id="fileTypeDistributionData" type="application/json">{!! json_encode($fileTypeDistribution) !!}</script>
<script src="{{asset("backend/js/Markread.js")}}"></script>

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Language Dropdown -->
<ul class="navbar-nav">
        <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" type="submit" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-globe fa-fw"></i>
          @if (session('locale') == 'ar')
              Ar
          @else
            En
          @endif
         </a>
            <div class="dropdown-menu dropdown-menu-left shadow animated--grow-in" aria-labelledby="languageDropdown">
                <a class="dropdown-item" href="{{ route('change.language', ['lang' => 'en']) }}">
                    <i class="fas fa-language fa-sm fa-fw mr-2 text-gray-400"></i>
                    English
                </a>
                <a class="dropdown-item" href="{{ route('change.language', ['lang' => 'ar']) }}">
                    <i class="fas fa-language fa-sm fa-fw mr-2 text-gray-400"></i>
                    العربية
                </a>
            </div>
        </li>
    </ul>

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav {{$auto}}">

        <!-- Nav Item - Alerts -->
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
        <h6 class="dropdown-header d-flex justify-content-between align-items-center">
            Alerts Center
            <a href="{{route('notifications.markAllAsRead')}}" class=" btn-link text-gray-500 " id="markAllAsRead">Mark all as read</a>
        </h6>
        @if(auth()->user()->unreadNotifications->count() > 0)
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
        @else
        <a class="dropdown-item d-flex align-items-center" href="#">
                <div class="mr-3">
                    <div class="icon-circle bg-light">
                        <i class="fas fa-info-circle text-gray-500"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">No new notifications</div>
                </div>
            </a>
        @endif

    </div>
</li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow ">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->first_name}}&nbsp;{{auth()->user()->last_name}}</span>
                <img class="img-profile rounded-circle mr-1" src="https://i.pinimg.com/originals/68/3d/8f/683d8f58c98a715130b1251a9d59d1b9.jpg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/profile/{{auth()->user()->id}}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    @lang('strings.profile')
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    @lang('strings.logout')
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
    <div class="col-xl-3 col-md-3 mb-4">
<div class="card card-custom border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> @lang('home.Total_Documents') </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $DocumentsForUser }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-user-circle-o fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        @lang('home.total_consumed_storage')
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $formattedTotalStorageUsed }}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-cloud-upload-alt fa-2x text-gray-300"></i>
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
                            @lang('home.total_documents_department')</div>
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
                           @lang('home.storage_usage_by_you')
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
    <!-- <div class="col-xl-3 col-md-6 mb-4">
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
    </div> -->
</div>
    

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow mb-4" style="height: 100%;">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">@lang('home.document_upload_overview')</h6>
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
                    <h6 class="m-0 font-weight-bold text-primary">@lang('home.file_types')</h6>
                    
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
                        <h6 class="m-0 font-weight-bold text-primary">@lang('home.departments')</h6>
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
                            <h6 class="m-0 font-weight-bold text-primary">@lang('home.recent_files')</h6>
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
                                    @lang('home.browse_more') &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                    <div class="col-lg-5 mb-4">
                        <div class="card shadow mb-4" style="width: 450px; height: 150px;">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">@lang('home.recent_files')</h6>
                            </div>
                            <div class="card-body" style="height: 100%; overflow-y: auto;">
                                <p>@lang('home.no_recent')</p>
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
    var csrfToken = '{{ csrf_token() }}';
    var markAllAsReadUrl = '{{ route('notifications.markAllAsRead') }}';
</script>