<?php
$text_align = app()->getLocale() == 'ar' ? 'text-right' :'';
?>


@extends('dashboard.layouts.app')
@section("title", "Upload File - Archive Cloud")  
@section('content')   
<style>
.error-message {
    text-align: left;
    margin-top: 10px;
    margin-bottom: 10px;
}

.error-message .alert {
    padding: 10px 15px;
    border-radius: 4px;
}

.error-message .alert li {
    font-size: 18px;
    line-height: 1.4;
}
</style>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">

                            @if ($errors->any())
                            <div class="error-message">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif

                            <h1 class="h4 text-gray-900 mb-4">@lang('showfileandtypes.Upload_File')</h1>
                            </div>
                          
                            <form class="user" action="{{ route('upload-file') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="title" placeholder="@lang('showfileandtypes.File_Title')" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="description" placeholder="@lang('showfileandtypes.File_description')" >
                                </div>
                                
                                <div class="form-group">
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">@lang('showfileandtypes.Select_Section')</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" id="file_type" name="file_type">
                                        <option value="">@lang('showfileandtypes.Select_File_Type')</option>
                                        @foreach ($fileTypes as $fileType)
                                            <option value="{{ $fileType->id }}">{{ $fileType->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group {{$text_align}}">
                                    <input type="checkbox" id="responsibility-checkbox" name="responsibility" required>
                                    <label for="responsibility-checkbox">
                                    @lang('showfileandtypes.responsibility_massaage')
                                    </label>
                                    </label>
                                </div>
                                <div class="form-group {{$text_align}}">
                                    <input type="file" class="form-control-file" id="file" name="file" style="display: none;" onchange="updateFileName(this)">
                                    <label for="file" class="btn btn-secondary btn-sm">@lang('showfileandtypes.Choose_File')</label>
                                    <span class="file-name">@lang('showfileandtypes.No_file_chosen')</span>
                                    </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                @lang('showfileandtypes.Upload_File')
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('responsibility-checkbox').addEventListener('change', function() {
            document.getElementById('upload-button').disabled = !this.checked;
        });
    </script>

<script>
  function updateFileName(input) {
    var fileNameSpan = document.querySelector('.file-name');
    if (input.files.length > 0) {
      fileNameSpan.textContent = input.files[0].name;
    } else {
      fileNameSpan.textContent = '@lang('showfileandtypes.No_file_chosen')';
    }
  }
</script>

@endsection