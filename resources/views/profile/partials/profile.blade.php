@extends('dashboard.layouts.app')
@section("title", "Edit profile")  
@section('content') 

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
                <img class="img-profile rounded-circle" src="https://i.pinimg.com/originals/68/3d/8f/683d8f58c98a715130b1251a9d59d1b9.jpg">
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


<div class="container mt-4">
    <div class="main-body">
          <div class="row gutters-sm">

        

            <div class="col-md-4 mb-3">


            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column justify-content-center align-items-center text-center">
                    <img src="https://i.pinimg.com/originals/68/3d/8f/683d8f58c98a715130b1251a9d59d1b9.jpg" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                        <h4>{{$user->name}}</h4>
                        <p class="text-secondary mb-1">{{$user->department->department}} user</p>
                    </div>
                    <a href="{{route('profile.edit' , $user->id)}}" class="btn btn-primary btn-user btn-circle">
                        <i class="far fa-edit"></i>
                    </a>
                    </div>
                </div>
            </div>


              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="fas fa-hdd fa-x text-gray-700 mr-2"></i><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Max Storage allowed</h6>
                    <span class="text-secondary">{{ round($userStorageLimit /1024 ,2) }} GB</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="fa fa-folder fa-x text-gray-700 mr-2"></i><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Storage used</h6>
                    <span class="text-secondary">{{ round($usagePercentage, 2) }}%</span>
                  </li>
                </ul>
              </div>
              @if (auth()->user()->isAdmin())
              <div class="card mt-1">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                  <a class="btn btn-primary btn-user btn-block"  data-toggle="modal" data-target="#permissionModal">Storage allowance</a>
                  <span class="text-secondary"></span>
                  </li>
                </ul>
              </div>
              @endif
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$user->name}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{$user->email}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Departmen</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$user->department->department}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Number of files</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                      {{$filesNumber}}
                    </div>
                  </div>
                </div>
              </div>
              <div class="row gutters-sm">
                <div class="col-sm-6 mb-3">
                  <div class="card ">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3"><i class="fa fa-bar-chart text-info mr-2"></i>Participation in Categories</h6>
                      @if (!empty($participationPercentages))
                            @foreach ($participationPercentages as $category => $percentage)
                            <div class="d-flex justify-content-between">
                                <small>{{ $category }}</small>
                                <small>{{ $percentage }}%</small>
                            </div>
                            <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            @endforeach
                        @else
                            <p>No participation data available.</p>
                        @endif
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                  <div class="card-body">
                        <h6 class="d-flex align-items-center mb-3">
                            <i class="fa fa-bar-chart text-info mr-2"></i>Storage consumtion by category
                        </h6>
                        @if (!empty($fileSizes))
                            @foreach ($fileSizes as $category => $size)
                            <div class="d-flex justify-content-between">
                                <small>{{ $category }}</small>
                                <small>{{ $size }} MB</small>
                            </div>
                            <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $size / (2 * 1024) * 100 }}%" aria-valuenow="{{ $size }}" aria-valuemin="0" aria-valuemax="2048"></div>
                            </div>
                            @endforeach
                            <div class="d-flex justify-content-between">
                                <small>Total size consumed</small>
                                <small>{{ $totalFileSize}} MB</small>
                            </div>
                            <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $usagePercentage }}%" aria-valuenow="{{ $usagePercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @else
                            <p>No file upload data available.</p>
                        @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection


<!-- edit employee permissions-->
<div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="permissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="permissionModalLabel">Edit Employee Permissions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="employee-permission-form" action="{{route('edit.Storage.Size', $user->id )}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="totalUploadSize">Total Upload Size</label>
                        <input type="number" class="form-control" id="totalUploadSize" name="storage_size" value="{{ $user->storage_size }}" required>
                        <small class="form-text text-muted">Enter the total upload size in MB</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="employee-permission-form" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>