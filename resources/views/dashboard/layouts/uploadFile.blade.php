<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="backend/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="backend/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="backend/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>
            <li class="nav-item active">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Log out</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div id="content">
                <div class="container-fluid"> <!-- Added container-fluid for full-width content -->

                    <!-- Upload Form -->
                    <form action='/upload-file' method="POST" enctype="multipart/form-data" class="mt-4 mb-4">
                        @csrf

                        <div class="form-group">
                        <label>Title</label>
                            <input type="text" class="form-control" name="title" placeholder="File title" required>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Section</label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select Section</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="file_type">File Type</label>
                            <select class="form-control" id="file_type" name="file_type">
                                <option value="">Select File Type</option>
                                @foreach ($fileTypes as $fileType)
                                    <option value="{{ $fileType->id }}">{{ $fileType->type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" class="form-control-file" id="file" name="file">
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                    <!-- End Upload Form -->

                    <!-- Footer -->
                    <footer class="sticky-footer bg-white mt-4 mb-4">
                        <!-- Add mt-4 (margin-top) and mb-4 (margin-bottom) -->
                        <div class="container my-auto">
                            <div class="text-center">
                                <span>Copyright &copy; Your Website 2020</span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->

                </div>
                <!-- End of Container Fluid -->
            </div>
            <!-- End of Content -->
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="backend/vendor/jquery/jquery.min.js"></script>
    <script src="backend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="backend/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="backend/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="backend/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="backend/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="backend/js/demo/datatables-demo.js"></script>
</body>

</html>
