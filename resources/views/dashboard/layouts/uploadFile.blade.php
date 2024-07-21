<form action="{{ route('upload-file') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <input type="text" name="title" placeholder="file title" required>
    </div>
    
    <div class="form-group">
        <label for="category_id">Section</label>
        <select class="form-control" id="category_id" name="category_id">
            <option value="">Select Section</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="file_type">File Type</label>
        <select class="form-control" id="file_type" name="file_type">
            <option value="">Select File Type</option>
            @foreach ($fileTypes as $fileType)
                <option value="{{ $fileType->id }}">{{ $fileType->type }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="file">File</label>
        <input type="file" class="form-control-file" id="file" name="file">
    </div>

    <button type="submit" class="btn btn-primary">Upload</button>
</form>