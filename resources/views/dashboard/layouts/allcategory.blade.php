<?php
    $auto = app()->getLocale() == 'ar' ? 'mr-auto' :'ml-auto';
    $text_align =  app()->getLocale() == 'ar' ? 'text-right' :'text-left';
    $margin =  app()->getLocale() == 'ar' ? 'ml' :'mr';
?>
@extends('dashboard.layouts.app')

@section("title", content: "All Files")  

@section('content')

<style>
   .rotated-button {
    transform: rotate(180deg); /* Rotate the button */
}

.rotated-button i {
    transform: rotate(-180deg); /* Rotate the icon back to its original position */
}



</style>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline ml-md-3 my-2 my-md-0 navbar-search" action="{{ route('category.show.all') }}" method="GET">
        <div class="input-group">
            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="@lang('allcategory.search_placeholder')" aria-label="Search" aria-describedby="basic-addon2" value="{{request('search') }}">
            <div class="input-group-append">
            <button class="btn btn-primary rotated-button" type="submit">
    <i class="fas fa-search fa-sm"></i>
</button>


            </div>
        </div>
    </form>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('category.show.all') }}" class="form-inline ml-2">
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-funnel-fill"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="filterDropdown">
                <button class="dropdown-item" onclick="event.preventDefault(); document.getElementById('file_type_all').selected = true; this.form.submit();">
                    @lang('allcategory.filter_all_types')
                </button>
                @foreach($fileTypes as $type)
                    <button class="dropdown-item" onclick="event.preventDefault(); document.getElementById('file_type_{{ $type->id }}').selected = true; this.form.submit();">
                        {{ $type->type }}
                    </button>
                @endforeach
                <select name="file_type" class="form-control" style="display: none;">
                    <option id="file_type_all" value="all">@lang('allcategory.filter_all_types')</option>
                    @foreach($fileTypes as $type)
                        <option id="file_type_{{ $type->id }}" value="{{ $type->id }}" {{ request('file_type') == $type->id ? 'selected' : '' }}>{{ $type->type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
</nav>

<div class="container mt-4">
    <h1 class="mb-4 {{$text_align}}">@lang('strings.all_files')</h1>
    <div class="row">
        @if (count($storageItems) > 0)
            @foreach ($storageItems as $item)
            <div class="col-md-3 mb-4">
                @php
                    switch ($item->file_type) {
                        case 1:
                            $cardClass = 'border-info';
                            $cardHeader = 'Document';
                            $cardBodyClass = 'text-info';
                            $icon = 'fa fa-file';
                            break;
                        case 2:
                            $cardClass = 'border-warning';
                            $cardHeader = 'Power Point';
                            $cardBodyClass = 'text-warning';
                            $icon = 'fa fa-file-powerpoint-o';
                            break;
                        case 3:
                            $cardClass = 'border-success';
                            $cardHeader = 'Image';
                            $cardBodyClass = 'text-success';
                            $icon = 'fa fa-file-image-o';
                            break;
                        case 4:
                            $cardClass = 'border-primary';
                            $cardHeader = 'Video';
                            $cardBodyClass = 'text-primary';
                            $icon = 'fa fa-file-movie-o';
                            break;
                        case 5:
                            $cardClass = 'border-danger';
                            $cardHeader = 'PDF';
                            $cardBodyClass = 'text-danger';
                            $icon = 'fa fa-file-pdf-o';
                            break;
                        default:
                            $cardClass = 'border-info';
                            $cardHeader = 'Document';
                            $cardBodyClass = '';
                            $icon = 'fa fa-file-pdf-o';
                            break;
                    }
                @endphp

                <div class="card {{ $cardClass }} mb-2 d-flex flex-column" style="max-width: 18rem; ">
                    <a href="{{route('departmentStorage.view', $item)}}" target="_blank" class="text-decoration-none text-reset">
                        <div class="card-header">
                            <i class="{{$icon}}" style="font-size:24px"></i>
                        </div>
                        <div class="card-body {{ $cardBodyClass }} d-flex flex-column flex-grow-1">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text flex-grow-1">{{ $item->description ?? "No description" }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">@lang('allcategory.uploaded_by') {{ $item->user->name ?? "Deleted user" }}</small>
                            <a href="{{ route('departmentStorage.download', $item->id) }}" class="btn ">
                                <i class="fa fa-download" style="font-size:18px"></i>
                            </a>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12 text-center">
                <h3>@lang('allcategory.no_results_found')</h3>
            </div>
        @endif
    </div>
</div>
@endsection