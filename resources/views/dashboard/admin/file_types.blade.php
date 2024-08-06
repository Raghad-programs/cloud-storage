@extends('dashboard.layouts.app')
@section("title", "Employees")  
@section('content')  
    <!-- Begin Page Content -->
    <div class="container">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">            <div class="col-md-8">
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