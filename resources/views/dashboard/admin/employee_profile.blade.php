@extends('dashboard.layouts.app')
@section("title", $employee->name." profile")  
@section('content')  
<div class="container mt-4">
    <div class="main-body">

          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="https://i.pinimg.com/originals/68/3d/8f/683d8f58c98a715130b1251a9d59d1b9.jpg" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4>{{$employee->name}}</h4>
                      <p class="text-secondary mb-1">{{$employee->department->department}} employee</p>                     
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="fas fa-hdd fa-x text-gray-700 mr-2"></i><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Max Storage allowed</h6>
                    <span class="text-secondary">{{ round($employeeStorageLimit /1024 ,2) }} GB</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="fa fa-folder fa-x text-gray-700 mr-2"></i><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Storage used</h6>
                    <span class="text-secondary">{{ round($usagePercentage, 2) }}%</span>
                  </li>
                  
                </ul>
              </div>

              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                  <a class="btn btn-primary btn-user btn-block" href="{{route('show-employee' , $employee->id)}}">View Employee files</a>
                  <span class="text-secondary"></span>
                  </li>
                </ul>
              </div>

              <div class="card mt-1">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                  <a class="btn btn-primary btn-user btn-block"  data-toggle="modal" data-target="#permissionModal">Storage allowance</a>
                  <span class="text-secondary"></span>
                  </li>
                </ul>
              </div>

            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$employee->name}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      {{$employee->email}}
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Departmen</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    {{$employee->department->department}}
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
                <form id="employee-permission-form" action="{{route('edit.Storage.Size', $employee->id )}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="totalUploadSize">Total Upload Size</label>
                        <input type="number" class="form-control" id="totalUploadSize" name="storage_size" value="{{ $employee->storage_size }}" required>
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