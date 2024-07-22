@extends('dashboard.layouts.app')
@section("title", "Upload File - Archive Cloud")  
@section('content')   
<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                            @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                     @endif
                                <h1 class="h4 text-gray-900 mb-4">Upload File</h1>
                            </div>
                            @if (auth()->user()->role_id == 1)
            <form class="user" action="{{ route('upload-file') }}" method="POST" enctype="multipart/form-data">
            @else
            <form class="user" action="{{ route('upload-file') }}" method="POST" enctype="multipart/form-data">
            @endif
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
@endsection