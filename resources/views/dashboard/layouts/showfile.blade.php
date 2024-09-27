@extends('dashboard.layouts.app')
@section("title", "my documents")  
@section('content')   
<!-- Main Content -->
<div id="content">
    <!-- Begin Page Content -->
    <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    @if (app()->getLocale() == 'en')
        <h3 class="m-0 font-weight-bold text-primary">{{ $userName }} @lang('showfileandtypes.Files')</h3>
        <a href="{{ route('download.all') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> @lang('showfileandtypes.Download_all_files')
        </a>
    @else
        <h3 class="m-0 font-weight-bold text-primary">@lang('showfileandtypes.Files'){{ $userName }}</h3>
        <a href="{{ route('download.all') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> @lang('showfileandtypes.Download_all_files')
        </a>
    @endif
</div>
        <div class="card-body">
           @livewire('department-storage-view')
        </div>
    </div>
</div>
<!-- End of Main Content -->

<script>
$(document).ready(function() {
    // Add a click event listener to the delete buttons
    $('.delete-btn').click(function() {
        var id = $(this).data('id');
        var url = '{{ route("destroy", ":id") }}';
        url = url.replace(':id', id);

        // Set the form action to the correct URL
        $('#deleteForm-' + id).attr('action', url);

        // Show the confirmation modal
        $('#deleteModal-' + id).modal('show');
    });
});
</script>
@endsection