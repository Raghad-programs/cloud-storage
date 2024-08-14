<!DOCTYPE html>
<html lang="en" @if(App::getlocale()=='ar')
    dir="rtl"
    @else
    dir="ltr"
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

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- file-type icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{asset("backend/css/sb-admin-2.min.css")}}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon ml-2">
                <i class="material-icons" style="font-size:43px">cloud_upload</i>
                </div>
                <div class="sidebar-brand-text mx-3">Archive Cloud<sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Files
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUploadFileMenu"
                    aria-expanded="true" aria-controls="collapseUploadFileMenu">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Categories</span>
                </a>
                <div id="collapseUploadFileMenu" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                    <a href="{{ route('category.show.all') }}" class="collapse-item">
                            <strong>All Files</strong>
                        </a>
                    @foreach ($categories as $category)
                    <a href="#" class="collapse-item" onclick="event.preventDefault(); document.getElementById('category-form-{{ $category->id }}').submit();">
                        {{ $category->name }}
                    </a>

                    <form id="category-form-{{ $category->id }}" action="{{ route('category.show', ['id' => $category->id]) }}" method="GET" style="display: none;">
                        @csrf
                    </form>
                    @endforeach

                    @if(auth()->user()->isAdmin())
                    <a href="#" class="collapse-item" data-toggle="modal" data-target="#newCategoryModal" style=" color: #6c757d; text-decoration: none;">
                        Add a new category
                     </a>
                    @endif
                    </div>
                </div>
            </li>

                <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('upload-file')}}">
                    <i class="fa fa-cloud-upload"></i>
                    <span>upload file</span></a>
            </li>

           
           

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('show-file')}}">
                    <i class="fa fa-archive"></i>
                    <span>my archival</span></a>
            </li>



            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            @if (auth()->user()->isAdmin())
            <!-- Heading -->
            <div class="sidebar-heading">
                Admin
            </div>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('administration.files') }}">
                    <i class="fa fa-newspaper-o"></i>
                    <span>All Files</span>
                </a>
            </li>


            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('table')}}">
                    <i class="fa fa-users"></i>
                    <span>Employees</span></a>
            </li>
            
            <!-- Nav Item - Charts -->
            <li class="nav-item">
            <a class="nav-link" href="{{ route('getfile.types') }}">
            <i class="fa fa-file-archive-o"></i>
                    <span>File types</span></a>
            </li>
            @endif



            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
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
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

   

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

</body>
</html>


<!-- Modal for new category -->
<div class="modal fade" id="newCategoryModal" tabindex="-1" role="dialog" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCategoryModalLabel">Add a new category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="new-category-form" action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="categoryName">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="new-category-form" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
