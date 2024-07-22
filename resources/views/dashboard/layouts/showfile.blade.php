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
        </tr>
    </thead>
    <tbody>
        @foreach ($departmentStorages as $storage)
        <tr>
            <td>{{ $storage->title }}</td>
            <td>{{ $storage->department->department }}</td>
            <td>{{ optional($storage->category)->name ?? '-' }}</td>
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
                    {{ basename($storage->file) }}
                </a>
            </td>
            <td>{{ $storage->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
        </div>
    </div>
</div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        @endsection  