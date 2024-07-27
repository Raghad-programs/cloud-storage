@extends('dashboard.layouts.app')
@section("title", "my documents")  
@section('content')   
            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="card shadow mb-4">
    <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">{{ $userName }} Files</h6>
    </div>
    <div class="card-body">
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
            <th>actions</th>
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
                <a href="{{ Storage::url($storage->file) }}" target="_blank">
                    Click to view file
                </a>
            </td>
            <td>{{ $storage->created_at }}</td>
            <td>
            <button class="btn btn-danger btn-circle text-gray-200 mb-1" data-id="{{ $storage->id }}" data-toggle="modal" data-target="#deleteModal">
                <i class="fas fa-trash"></i>
            </button>
             <a type="submit" class="btn btn-circle bg-gradient-warning text-gray-200" href="{{route('edit.file' , $storage->id)}}">
                <i class="fas fa-edit ml-1" style="color: bg-white; font-size:18px" ></i>
             </a>    
  
        </tr>
        @endforeach
    </tbody>
</table>
        </div>

        


    </div>
</div>



    
</div>
 <!-- End of Main Content -->


<!-- Delete modal -->
 <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <form method="POST" action="{{ route('destroy' , $storage->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-primary">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>$(document).ready(function() {
    // Add a click event listener to the delete buttons
    $('.btn-danger.btn-circle').click(function() {
        var id = $(this).data('id');
        var url = '{{ route("destroy", ":id") }}';
        url = url.replace(':id', id);

        // Show the confirmation modal
        $('#deleteModal').modal('show');

        // Handle the form submission in the modal
        $('#deleteModal form').attr('action', url);
    });
});

</script>
@endsection  