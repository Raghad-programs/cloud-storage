@extends('dashboard.layouts.app')
@section("title", "File Types Edit")  
@section('content')  
<div class="container-fluid" style="margin-top: 160px;">    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit File Type</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('update.filetype', $fileType->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group">
                            <label for="type">File Type</label>
                            <input type="text" class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="{{ old('type', $fileType->type) }}">
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group" id="extensions-group">
                            <label for="extensions">Extensions</label>
                            @php
                                $extensions = explode(',', $fileType->extensions);
                            @endphp
                            @foreach ($extensions as $index => $extension)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control @error('extensions.*') is-invalid @enderror extensions" name="extensions[]" value="{{ trim($extension) }}">
                                    <div class="input-group-append">
                                        @if ($index > 0)
                                            <button type="button" class="btn btn-danger" onclick="removeExtensionField(this)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        @endif
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

                        <button type="submit" class="btn btn-primary">Update File Type</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
@endsection
