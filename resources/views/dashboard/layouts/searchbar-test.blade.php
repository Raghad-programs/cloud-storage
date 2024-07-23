@extends('dashboard.layouts.app')
@section("title", "search test")  
@section('content')

<!-- Topbar Search -->
<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-4 mw-100 navbar-search" action="{{ '/search'}}" method="GET">
    <div class="input-group ">
        <input type="text" class="form-control bg-light border-3 small border-bottom-primary" placeholder="Search for a file..." aria-label="Search" aria-describedby="basic-addon2" name="query">
        <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form>

<div class="container mt-4">
    <div class="row">
        @if (count($results) > 0)
            @foreach ($results as $result)
            @php
                switch ($result->file_type) {
                    case 1:
                        $cardClass = 'border-info';
                        $cardHeader = 'Document';
                        $cardBodyClass = 'text-info';
                        $icon= "fa fa-file";
                        break;
                    case 2:
                        $cardClass = 'border-warning';
                        $cardHeader = 'Power Point';
                        $cardBodyClass = 'text-warning';
                        $icon= "fa fa-file-powerpoint-o";
                        break;
                    case 3:
                        $cardClass = 'border-success';
                        $cardHeader = 'Image';
                        $cardBodyClass = 'text-success';
                        $icon= "fa fa-file-image-o";
                        break;
                    case 4:
                        $cardClass = 'border-primary';
                        $cardHeader = 'Video';
                        $cardBodyClass = 'text-primary';
                        $icon= "fa fa-file-movie-o";

                        break;
                    case 5:
                        $cardClass = 'border-danger';
                        $cardHeader = 'PDF';
                        $cardBodyClass = 'text-danger';
                        $icon= "fa fa-file-pdf-o";

                        break;
                    default:
                        $cardClass = 'border-info';
                        $cardHeader = 'Document';
                        $cardBodyClass = '';
                        $icon= "fa fa-file";
                        break;
                }
            @endphp

            <div class="col-md-3 mb-4">
                <div class="card {{ $cardClass }} mb-2 " style="max-width: 18rem; ">
                    <a href="{{ route('search', $result->id) }}" class="text-decoration-none text-reset">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <!-- Your existing card header content -->
                            </div>
                            <div>
                                <i class="{{ $icon }}" style="font-size:24px"></i>
                            </div>
                        </div>
                        <div class="card-body {{ $cardBodyClass }}">
                            <h5 class="card-title">{{ $result->title }}</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Uploaded by {{ $result->user->name }}</small>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        @else
            <p>No results found.</p>
        @endif
    </div>
</div>

@endsection