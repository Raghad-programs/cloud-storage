@extends('dashboard.layouts.app')

@section("title", $category->name)  

@section('content')

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="{{ route('category.search', $category->id) }}" method="GET">
        <div class="input-group">
            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2"  value="{{old('search')}}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>
</nav>


<div class="container mt-4">
    <h1 class="mb-4">{{ $category->name }}</h1>
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
                        break;
                    case 2:
                        $cardClass = 'border-warning';
                        $cardHeader = 'Power Point';
                        $cardBodyClass = 'text-warning';
                        break;
                    case 3:
                        $cardClass = 'border-success';
                        $cardHeader = 'Image';
                        $cardBodyClass = 'text-success';
                        break;
                    case 4:
                        $cardClass = 'border-primary';
                        $cardHeader = 'Video';
                        $cardBodyClass = 'text-primary';
                        break;
                    case 5:
                        $cardClass = 'border-danger';
                        $cardHeader = 'PDF';
                        $cardBodyClass = 'text-danger';
                        break;
                    default:
                        $cardClass = 'border-info';
                        $cardHeader = 'Document';
                        $cardBodyClass = '';
                        break;
                }
            @endphp

            <div class="card {{ $cardClass }} mb-2 " style="max-width: 18rem; ">
            <a href="{{ Storage::url($item->file) }}" target="_blank" class="text-decoration-none text-reset">
                <div class="card-header">{{ $cardHeader }}</div>
                <div class="card-body {{ $cardBodyClass }}">
                    <h5 class="card-title">{{ $item->title }}</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Uploaded by {{ $item->user->name }}</small>
                </div>
            </div>
        </div>


        @endforeach
        @else
            <div class="col-12 text-center">
                <h3>No result found.</h3>
            </div>
        @endif

    </div>
</div>
@endsection