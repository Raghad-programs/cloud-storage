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
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->first_name}}&nbsp;{{auth()->user()->last_name}}</span>
                <img class="img-profile rounded-circle" src="https://i.pinimg.com/originals/68/3d/8f/683d8f58c98a715130b1251a9d59d1b9.jpg">
            </a>
             <!-- Dropdown - User Information -->
             <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/profile/{{auth()->user()->id}}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
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



<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- User profile card -->
            <div class="card mb-1">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="https://i.pinimg.com/originals/68/3d/8f/683d8f58c98a715130b1251a9d59d1b9.jpg" alt="Admin" class="rounded-circle" width="150">
                        <div class="mt-3">
                            <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                            <p class="text-secondary mb-1">{{ $user->department->department }} user</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User profile form -->
            <form action="{{ route('profile.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card mb-1">
                    <div class="card-body">
                        <!-- Full name -->
                        <div class="row">
                            <div class="col-sm-3 mt-2">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="row">
                                <div class="col-sm-10 ml-3">
                                    <input name="first_name" type="text" class="form-control" value="{{ $user->first_name }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <input name="last_name" type="text" class="form-control" value="{{ $user->last_name }}">
                                </div>
                            </div>
                        </div>
                        <hr>

                        <!-- Email -->
                        <div class="row">
                            <div class="col-sm-3 mt-2">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9">
                                <input name="email" type="text" class="form-control" value="{{$user->email}}">
                            </div>
                        </div>
                        <hr>

                        <!-- Phone number -->
                        <div class="row">
                            <div class="col-sm-3 mt-2">
                                <h6 class="mb-0">Phone number</h6>
                            </div>
                            <div class="col-sm-9">
                                <input name="phone_number" type="text" class="form-control" value="{{ $user->phone_number }}">
                            </div>
                        </div>
                        <hr>

                        <!-- Linkedin -->
                        <div class="row">
                            <div class="col-sm-3 mt-2">
                                <h6 class="mb-0">linkedin</h6>
                            </div>
                            <div class="col-sm-9">
                                <input name="email" type="text" class="form-control" value="{{$user->linkedin_url}}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update profile button -->
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <button type="submit" class="btn btn-primary btn-user btn-block">Update profile</button>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</div>

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