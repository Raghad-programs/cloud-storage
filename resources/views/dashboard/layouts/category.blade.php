@extends('dashboard.layouts.app')

@section('title', $category->name)

@section('content')

<style>
.btn-download {
  display: inline-flex;
  align-items: center;
  justify-content: flex-end;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z' fill='%23707070'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-size: 16px 16px;
  background-position: right center;
  padding-right: 24px;
  color: #707070;
}
</style>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline ml-md-3 my-2 my-md-0 navbar-search" action="{{ route('category.show', $category->id) }}" method="GET">
        <div class="input-group">
            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" value="{{request('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('category.show', $category->id) }}" class="form-inline ml-2">
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-funnel-fill"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="filterDropdown">
                <button class="dropdown-item" onclick="event.preventDefault(); document.getElementById('file_type_all').selected = true; this.form.submit();">
                    All Types
                </button>
                @foreach($fileTypes as $type)
                    <button class="dropdown-item" onclick="event.preventDefault(); document.getElementById('file_type_{{ $type->id }}').selected = true; this.form.submit();">
                        {{ $type->type }}
                    </button>
                @endforeach
                <select name="file_type" class="form-control" style="display: none;">
                    <option id="file_type_all" value="all">All Types</option>
                    @foreach($fileTypes as $type)
                        <option id="file_type_{{ $type->id }}" value="{{ $type->id }}" {{ request('file_type') == $type->id ? 'selected' : '' }}>{{ $type->type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
</nav>

<div id="resultsContainer">
    <div class="container mt-4">
        <h1 class="mb-4">{{ $category->name }}</h1>
        <div class="row">
            @if(count($storageItems) > 0)
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

                        <div class="card {{ $cardClass }} mb-2 " style="max-width: 18rem; ">
                            <a href="{{route('departmentStorage.view', $item)}}" target="_blank" class="text-decoration-none text-reset">
                                <div class="card-header">
                                    <i class="{{$icon}}" style="font-size:24px"></i>
                                </div>
                                <div class="card-body {{ $cardBodyClass }}">
                                    <h5 class="card-title">{{ $item->title }}</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                                    <div class="card-footer">
                                    <small class="text-muted">Uploaded by {{ $item->user->name }}</small>
                                    <button type="button" onclick="window.location.href='{{ route('file.download', $item->id) }}'" class="btn btn-default btn-sm btn-download">
                                </button>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection