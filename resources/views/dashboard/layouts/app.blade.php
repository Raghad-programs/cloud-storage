<?php
    $text_align = app()->getLocale() == 'ar' ? 'text-right' :'';
?>

<!DOCTYPE html>
<html @if(App::getlocale()=='ar')
    dir="rtl"
    lang="ar"
    @else
    dir="ltr"
    lang="en" 
    @endif
     >
<head>
<link rel="icon" type="image/png" sizes="512x512" href={{asset("backend/img/logo.png")}}>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset("backend/vendor/fontawesome-free/css/all.min.css")}}" rel="stylesheet" type="text/css">



    <!-- profile style -->
    <link href="{{asset("backend/css/profile.css")}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
    <!-- <link href="{{asset("backend/css/sb-admin-2-rtl.css")}}" rel="stylesheet"> -->

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- file-type icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{asset("backend/css/sb-admin-2.min.css")}}" rel="stylesheet">
    @livewireStyles
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion d-flex" id="accordionSidebar" style="padding:0px ;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center " href="">
                <div class="sidebar-brand-icon">
                 <i class="material-icons" style="font-size:43px">cloud_upload</i>
                </div>
                <div class="sidebar-brand-text mx-3 {{$text_align}}">
                    @lang('strings.cloud_archive')
                 </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <div class="sidebar-item ">
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a class="nav-link {{$text_align}} my-0" href="{{route('dashboard')}} ">
                        <i class="fas fa-fw fa-tachometer-alt" ></i>
                        <span>@lang('strings.dashboard')</span></a>
                </li>
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Heading -->
            <div class="sidebar-heading {{$text_align}}">
                @lang('strings.files')
            </div>

            <li class="nav-item" >
                <a class="nav-link collapsed {{$text_align}}" href="#" data-toggle="collapse" data-target="#collapseUploadFileMenu"
                    aria-expanded="true" aria-controls="collapseUploadFileMenu" >
                    <i class="fas fa-fw fa-folder"></i>
                    <span>@lang('strings.categories')</span>
                </a>
                <div id="collapseUploadFileMenu" class="collapse {{$text_align}}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                    <a href="{{ route('category.show.all') }}" class="collapse-item {{$text_align}} {{ request()->routeIs('category.show.all') ? 'active' : '' }}">
                            <strong>@lang('strings.all_files')</strong>
                        </a>
                    @foreach ($categories as $category)
                    <a href="#" class="collapse-item {{$text_align}} " onclick="event.preventDefault(); document.getElementById('category-form-{{ $category->id }}').submit();">
                        @if (App::getLocale()=='en')
                        {{ $category->name }}
                        @else
                        {{ $category->name_ar }}
                        @endif
                    </a>

                    <form id="category-form-{{ $category->id }}" action="{{ route('category.show', ['id' => $category->id]) }}" method="GET" style="display: none;">
                        @csrf
                    </form>
                    @endforeach

                    @if(auth()->user()->isAdmin())
                    <a href="#" class="collapse-item {{$text_align}} " data-toggle="modal" data-target="#newCategoryModal" style=" color: #6c757d; text-decoration: none;">
                        @lang('strings.add_category')
                     </a>
                    @endif
                    </div>
                </div>
            </li>

                <!-- Nav Item - Charts -->
            <li class="nav-item {{request()->routeIs('upload-file') ? 'active' : '' }}">
                <a class="nav-link {{$text_align}}" href="{{route('upload-file')}}">
                    <i class="fa fa-cloud-upload"></i>
                    <span>@lang('strings.upload')</span></a>
            </li>

           
           

            <!-- Nav Item - Tables -->
            <li class="nav-item {{request()->routeIs('show-file') ? 'active' : '' }}">
                <a class="nav-link {{$text_align}}" href="{{route('show-file')}}">
                    <i class="fa fa-archive"></i>
                    <span>@lang('strings.my_archival')</span></a>
            </li>



            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            @if (auth()->user()->isAdmin())
            <!-- Heading -->
            <div class="sidebar-heading {{$text_align}}">
                @lang('strings.admin')
            </div>

            <li class="nav-item {{ request()->routeIs('administration.files') ? 'active' : '' }}">
                <a class="nav-link {{$text_align}}" href="{{ route('administration.files') }}">
                    <i class="fa fa-newspaper-o"></i>
                    <span>@lang('strings.all_files')</span>
                </a>
            </li>


            <!-- Nav Item - Charts -->
            <li class="nav-item  {{ request()->routeIs('table') ? 'active' : '' }}">
                <a class="nav-link {{$text_align}}" href="{{route('table')}}">
                    <i class="fa fa-users"></i>
                    <span>@lang('strings.employees')</span></a>
            </li>
            
            <!-- Nav Item - Charts -->
            <li class="nav-item {{request()->routeIs('getfile.types') ? 'active' : '' }}">
            <a class="nav-link {{$text_align}}" href="{{ route('getfile.types') }}">
            <i class="fa fa-file-archive-o"></i>
                <span>@lang('strings.file_types')</span></a>
            </li>
            @endif



            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline ">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

           

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @yield('content')

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top" 
    style="{{ app()->getLocale() == 'ar' ? 'left: 20px; right: auto;' : '' }}">
    <i class="fas fa-angle-up"></i>
    </a>

    <style>
    .scroll-to-top {
    justify-content: center; /* Centers the arrow horizontally */
    align-items: center;     /* Centers the arrow vertically */
    width: 27x;             /* Set a width for the box */
    height: 27px;            /* Set a height for the box */
    position: fixed;         /* Fixes the position on the screen */
    bottom: 20px;            /* Position from the bottom of the screen */
    right: 20px;             /* Default position from the right of the screen */
    z-index: 1000;           /* Ensures it is above other content */
    }

    .scroll-to-top i {
    font-size: 24px;         /* Size of the arrow icon */
    color: #333;             /* Color of the arrow */
    }

    </style>

   

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset("backend/vendor/jquery/jquery.min.js")}}"></script>
    <script src="{{asset("backend/vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset("backend/vendor/jquery-easing/jquery.easing.min.js")}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset("backend/js/sb-admin-2.min.js")}}"></script>

    <!-- Page level plugins -->
    <script src="{{asset("backend/vendor/chart.js/Chart.min.js")}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset("backend/js/demo/chart-area-demo.js")}}"></script>
    <script src="{{asset("backend/js/demo/chart-pie-demo.js")}}"></script>
   @livewireScripts
</body>



<!-- Modal for new category -->
<div class="modal fade " id="newCategoryModal" tabindex="-1" role="dialog" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content {{$text_align}}">
            <div class="modal-header ">
                <h5 class="modal-title  " id="newCategoryModalLabel">@lang('strings.add_category')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="new-category-form" action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="categoryName">@lang('strings.category_name')</label>
                        <input type="text" class="form-control" id="categoryName" name="name" placeholder="@lang('strings.category_en')" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="categoryName" name="name_ar" placeholder="@lang('strings.category_ar')" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('strings.close')</button>
                <button type="submit" form="new-category-form" class="btn btn-primary">@lang('strings.save')</button>
            </div>
        </div>
    </div>
</div>


@if (app()->getLocale()=='ar')
    <style>
    .modal-header .close {
        margin-right: auto; /* Push the close button to the left */
        margin-left: 0; /* Remove any default right margin */
    }
    </style>
@endif
