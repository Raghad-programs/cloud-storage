@extends('dashboard.layouts.app')
@section("title", "my documents")  
@section('content')   
<!-- Main Content -->
<div id="content">
    <!-- Begin Page Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h3 class="m-0 font-weight-bold text-primary">{{ $userName }} Files</h3>
            <a href="{{ route('download.all') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Download all files
            </a>
        </div>
        <div class="card-body">
            @if(count($departmentStorages) == 0)
            <div class="text-center">
                <h4>No files uploaded yet.</h4>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Department Name</th>
                            <th>Category Name</th>
                            <th>File Type</th>
                            <th>File</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departmentStorages as $storage)
                        <tr>
                            <td>{{ $storage->title }}</td>
                            <td>{{ $storage->department->department }}</td>
                            <td>{{ $storage->category->name }}</td>
                            <td>
                                @if ($storage->file_type == 1)
                                    Document
                                @elseif ($storage->file_type == 2)
                                    PowePoint
                                @elseif ($storage->file_type == 3)
                                    Image
                                @elseif ($storage->file_type == 4)
                                    Video
                                @elseif ($storage->file_type == 5)
                                    PDF
                                @else
                                    {{ optional($storage->fileType)->type ?? '-' }}
                                @endif
                            </td>
                            <td>
                                <a href="{{route('departmentStorage.view', $storage) }}" target="_blank">
                                    Click to view file
                                </a>
                            </td>
                            <td>{{ $storage->created_at }}</td>
                            <td>
                                <button class="btn btn-danger btn-circle text-gray-200 mb-1 delete-btn" data-id="{{ $storage->id }}" data-toggle="modal" data-target="#deleteModal-{{ $storage->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <div class="modal fade" id="deleteModal-{{ $storage->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">Select "Delete" below if you sure you want to delete this file?</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                        <form method="POST" action="{{ route('destroy', $storage->id) }}" id="deleteForm-{{ $storage->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-primary">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
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