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
</style>

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
            <a href="{{ route('edit.filetype', $fileType->id) }}" class="btn btn-warning">Edit</a>
            <!-- Add delete button here -->
        </td>
    </tr>
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

<div class="container">
    <div class="row justify-content-start">
        <div class="col-md-10">
            <div class="card">
            <div class="card-header">Create New File Type</div>
            <div class="card-body">
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
@endsection