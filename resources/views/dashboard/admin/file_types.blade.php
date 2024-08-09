@extends('dashboard.layouts.app')
@section("title", "File Types")  
@section('content')  
<style>
    table.table th:nth-child(1) {
        width: 200px;
    }
    table.table th:nth-child(2) {
        width: 200px;
    }
    table.table th:nth-child(3) {
        width: 150px;
    }
    table.table th:nth-child(4) {
        width: 150px;
    }
    table.table td:nth-child(4) {
        text-align: center;
    }
    /* Allow modal to grow based on content */
    .modal-dialog {
        max-width: 90vw; /* Adjust as necessary */
        margin: 1.75rem auto; /* Center the modal */
    }

    .modal-content {
        width: 100%;
        height: auto; /* Ensure height is based on content */
    }

</style>

    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h2 class="text-gray-800 ">Already existing file types</h2>
        <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#newFileTypeModal">
        Add New File Type
        </a>
    </div>

<!-- Begin Page Content -->
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>File Type</th>
                    <th>Extension</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($fileTypes as $fileType)
    <tr>
        <td>{{ $fileType->type }}</td>
        <td>{{ $fileType->extensions}}</td>
        <td>{{ $fileType->created_at }}</td>
        <td>
        <button class="btn btn-danger btn-circle text-gray-200 mb-1 delete-btn" 
        data-id="{{ $fileType->id }}" data-toggle="modal" data-target="#deleteModal-{{ $fileType->id }}">
        <i class="fas fa-trash"></i>
        </button>
        <a type="submit" class="btn btn-circle bg-gradient-warning text-gray-200" 
        href="{{route('edit.filetype' , $fileType->id)}}">
        <i class="fas fa-edit ml-1" style="color: bg-white; font-size:18px" ></i>
        </a>
        </td>
    </tr>
    <div class="modal fade" id="deleteModal-{{ $fileType->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        </div>
                        <div class="modal-body">Select "Delete" below if you sure you want to delete this file type?</div>
                        <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <form method="POST" action="{{ route('destroy.filetype', $fileType->id) }}" id="deleteForm-{{ $fileType->id }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-primary" type="submit">Delete</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
@endforeach


            </tbody>
        </table>
    </div>
</div>

<script>
    $('.delete-btn').click(function() {
    var id = $(this).data('id');
    var url = '{{ route("destroy.filetype", ":id") }}';
    url = url.replace(':id', id);

    // Set the form action to the correct URL
    $('#deleteForm-' + id).attr('action', url);
    $('#deleteForm-' + id).attr('method', 'POST');
    $('#deleteForm-' + id).append('@method('DELETE')');

    // Show the confirmation modal
    $('#deleteModal-' + id).modal('show');
});
</script>


@endsection

<!-- New File Type Modal -->
<div class="modal fade" id="newFileTypeModal" tabindex="-1" role="dialog" aria-labelledby="newFileTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newFileTypeModalLabel">Create New File Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('file-types.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="type">File Type</label>
                        <input type="text" class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="{{ old('type') }}">
                        @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group" id="extensions-group">
                        <label for="extensions">Extensions</label>
                        @foreach (old('extensions', []) as $extension)
                        <div class="input-group mb-2">
                            <input type="text" class="form-control @error('extensions.*') is-invalid @enderror extensions" name="extensions[]" value="{{ $extension }}">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger" onclick="removeExtensionField(this)">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                        <div class="input-group mb-2">
                            <input type="text" class="form-control @error('extensions.*') is-invalid @enderror extensions" name="extensions[]" placeholder="Enter extension">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" onclick="addExtensionField()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        @error('extensions.*')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

<script>
                        function addExtensionField() {
                            var extensionsGroup = document.getElementById('extensions-group');
                            var extensionFields = extensionsGroup.getElementsByClassName('extensions');

                            if (extensionFields.length < 10) {
                                var newExtensionField = document.createElement('div');
                                newExtensionField.classList.add('input-group', 'mb-2');
                                newExtensionField.innerHTML = `
                                    <input type="text" class="form-control @error('extensions.*') is-invalid @enderror extensions" name="extensions[]" placeholder="Enter extension">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-danger" onclick="removeExtensionField(this)">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                `;
                                extensionsGroup.appendChild(newExtensionField);
                            } else {
                                alert('Maximum of 10 extensions reached.');
                            }
                        }

                        function removeExtensionField(button) {
                            var extensionField = button.closest('.input-group');
                            extensionField.remove();
                        }
                                        </script>

                    <button type="submit" class="btn btn-primary">Create File Type</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
