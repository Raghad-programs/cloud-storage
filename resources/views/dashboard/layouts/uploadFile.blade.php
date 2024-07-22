<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Upload File - Archive Cloud</title>

    <!-- Custom fonts for this template-->
    <link href="backend/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="backend/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Upload File</h1>
                            </div>
                            <form class="user" action="{{ route('upload-file') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="title" placeholder="File Title" required>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Select Section</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" id="file_type" name="file_type">
                                        <option value="">Select File Type</option>
                                        @foreach ($fileTypes as $fileType)
                                            <option value="{{ $fileType->id }}">{{ $fileType->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="file" class="form-control-file" id="file" name="file">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Upload File
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="backend/vendor/jquery/jquery.min.js"></script>
    <script src="backend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="backend/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="backend/js/sb-admin-2.min.js"></script>
</body>
</html>