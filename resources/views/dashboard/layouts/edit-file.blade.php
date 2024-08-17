<?php
$text_align = app()->getLocale() == 'ar' ? 'text-right' :'';
?>

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
                                <h1 class="h4 text-gray-900 mb-4">@lang('showfile.Update_File')</h1>
                            </div>
                                <form class="user" action="{{route('update.file', $storage->id ) }}" method="POST" enctype="multipart/form-data">
                                 @csrf
                                 @method('PATCH')
                                 
                                <div class="form-group {{$text_align}}" >
                                <label for="category_id" class="small">@lang('showfile.File_Title')</label>
                                    <input type="text" class="form-control form-control-user" name="title" placeholder="File Title" value="{{$storage->title}}" required>
                                </div>

                                <div class="form-group  {{$text_align}}">
                                <label for="category_id" class="small">@lang('showfile.File_Description')</label>

                                    <input type="text" class="form-control form-control-user" name="description" placeholder="File Description" value="{{$storage->description}}" required>
                                </div>


                                <div class="form-group  {{$text_align}}">
                                    <label for="category_id" class="small">@lang('showfile.Category_Name')</label>
                                    <select class="form-control form-control-sm" id="category_id" name="category_id">
                                        <option value="{{$storage->category_id}}">{{$storage->category->name}}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group  {{$text_align}}">
                                <label for="category_id" class="small">@lang('showfile.File_Type')</label>
                                    <select class="form-control" id="file_type" name="file_type">
                                    <option value="{{$storage->file_type}}">{{$storage->fileType->type}}</option>
                                        @foreach ($fileTypes as $fileType)
                                            <option value="{{ $fileType->id }}">{{ $fileType->type }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                @lang('showfile.Update')
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection