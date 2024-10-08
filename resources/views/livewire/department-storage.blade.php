<?php
$text_align = app()->getLocale() == 'ar' ? 'text-right' :'';
?>



<div>
<div class="table-responsive {{$text_align}}">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>@lang('showfileandtypes.Title')</th>
                            <th>@lang('showfileandtypes.Department_Name')</th>
                            <th>@lang('showfileandtypes.Category_Name')</th>
                            <th>@lang('showfileandtypes.File_Type')</th>
                            <th>@lang('showfileandtypes.File')</th>
                            <th>@lang('showfileandtypes.Created_At')
                            <span wire:click="sortBy('created_at')" class="float-right text-sm" style="cursor: pointer">
        <i class="fa fa-arrow-up {{ $sortColumnCreated_At == 'created_at' && $sortDirection == 'asc' ? '' : 'text-muted' }}" style="color:black"></i>
        <i class="fa fa-arrow-down {{ $sortColumnCreated_At == 'created_at' && $sortDirection == 'desc' ? '' : 'text-muted' }} " style="color:black"></i>
    </span>
            </th>
                            <th>@lang('showfileandtypes.Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departmentStorages as $storage)
                        <tr>
                            <td>{{ $storage->title }}</td>
                            <td>{{ $storage->department->department }}</td>
                            <td>{{ app()->getLocale() == 'en' ? $storage->category->name : $storage->category->name_ar }}</td>
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
                                @lang('showfileandtypes.Click_to_view_file')
                                </a>
                            </td>
                            <td>{{ $storage->created_at }}</td>
                            <td>
                                <button class="btn btn-danger btn-circle text-gray-200 mb-1 delete-btn" data-id="{{ $storage->id }}" data-toggle="modal" data-target="#deleteModal-{{ $storage->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <a type="submit" class="btn btn-circle bg-gradient-warning text-gray-200" href="{{route('edit.file' , $storage->id)}}">
                                    <i class="fas fa-edit ml-1" style="color: bg-white; font-size:18px" ></i>
                                </a>
                            </td>
                        </tr>
                        <div class="modal fade" id="deleteModal-{{ $storage->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">@lang('showfileandtypes.Confirm_Deletion')</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">@lang('showfileandtypes.Deletion_massage')</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">@lang('showfileandtypes.Cancel')</button>
                                        <form method="POST" action="{{ route('destroy', $storage->id) }}" id="deleteForm-{{ $storage->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-primary">@lang('showfileandtypes.Delete')</button>
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