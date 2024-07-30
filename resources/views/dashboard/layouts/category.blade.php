@extends('dashboard.layouts.app')

@section("title", $category->name)  

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

<div class="container mt-4">
    <h1 class="mb-4">{{ $category->name }}</h1>
    <div class="row">
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
                    <button type="button" onclick="window.location.href='{{ route('file.download', $item->file) }}'" class="btn btn-default btn-sm btn-download">
                     Download
                   </button>
                </div>
            </div>
        </div>


        @endforeach
    </div>
</div>
@endsection