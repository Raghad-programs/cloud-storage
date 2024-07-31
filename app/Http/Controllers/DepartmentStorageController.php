<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentStorageRequest;
use App\Http\Requests\UpdateDepartmentStorageRequest;
use App\Models\DepartmentStorage;
use App\Models\FileType;
use App\Models\Category;
use App\Models\User;
use App\Http\Controllers\Request;
use Illuminate\Support\Facades\Storage;

class DepartmentStorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $currentUserDepartment = auth()->user()->Depatrment_id ;
        $categories = Category::where('department_id', $currentUserDepartment)->get();
        $departmentStorages = DepartmentStorage::where('department_id', $currentUserDepartment)->get();
        $fileTypes = FileType::all();
        
        return view('dashboard.layouts.uploadFile',[
            'categories' => $categories,
            'departmentStorages' => $departmentStorages,
            'fileTypes' => $fileTypes,
        ]);
    }
    public function store(StoreDepartmentStorageRequest $request)
    {
    
    $validatedData = $request->validated();

    $fileType = FileType::find($validatedData['file_type']);
    $folderName = strtolower($fileType->type);
    //$filePath = $request->file('file')->store("department_storage/{$folderName}", 'local');
    $file = $request->file('file');

    // Check the file size
    $maxFileSize = $this->getMaxFileSize($fileType->type);
    if ($file->getSize() > $maxFileSize * 1024 * 1024) {
        flash()->error("The maximum file size for {$fileType->type} files is {$maxFileSize}MB.");
        return redirect(route('upload-file'));
    }

    // Check the user's total file size
    $departmentId = auth()->user()->Depatrment_id;
    $totalFileSize = $this->getUserTotalFileSize(auth()->id(), $departmentId);
    if ($totalFileSize + $file->getSize() > 2147483648){ // 2 GB
        flash()->error("You have reached the maximum file storage limit of {$maxFileSize}MB for your department.");
        return redirect(route('upload-file'));
    }
    $departmentId = auth()->user()->Depatrment_id;

    $filePath = $file->store("department_storage/{$folderName}", 'local');
  
    $departmentStorage = DepartmentStorage::create([
        'title'=>$request->title,
        'department_id' => $departmentId,
        'user_id' => auth()->id(),
        'category_id' => $request->category_id,
        'file_type' => $fileType->id,
        'file' => $filePath,
        'file_size' => $file->getSize(),
        'description'=>$request->description,
    ]);



    flash()->success('The file is saved successfully!!');
    return redirect(route('upload-file'));
    }
    private function getUserTotalFileSize($userId, $departmentId)
    {
    return DepartmentStorage::where('user_id', $userId)
        ->where('department_id', $departmentId)
        ->sum('file_size');
    }
     

    private function getMaxFileSize($fileType)
    {
    $maxFileSizes = [
        'Document' => 2, // 2 MB
        'Powerpoint' => 5, // 5 MB
        'Image' => 5, // 5 MB
        'Video' => 20, // 20 MB
        'PDF' => 5, // 5 MB
    ];

    return $maxFileSizes[$fileType] ?? 2; // Default to 2MB if not found
    }

    


    public function showfile()
    {
        $currentUserDepartment = auth()->user()->Depatrment_id ;
        $departmentStorages = DepartmentStorage::where('department_id', $currentUserDepartment)
                            ->where('user_id', auth()->id())
                            ->get();
                            $userName = auth()->user()->name;

        
        if (auth()->user()->role_id == 1) {
            return view('dashboard.layouts.showfile')
            ->with('departmentStorages', $departmentStorages)
            ->with('userName', $userName);
        } else {
            return view('dashboard.layouts.showfile')
            ->with('departmentStorages', $departmentStorages)
            ->with('userName', $userName);
        }
    }
    
    public function downloadFile($id)
    {
        $item = DepartmentStorage::findOrFail($id);
        $filePath = Storage::disk('local')->path($item->file);
        $file = Storage::disk('local')->get($item->file);
    
        return response($file, 200)
            ->header('Content-Type', mime_content_type($filePath))
            ->header('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"');
    }

    /**
     * Display the specified resource.
     */
    public function show_employee($id)
    {
        $departmentStorages = DepartmentStorage::where('department_id', auth()->user()->Depatrment_id)
        ->where('user_id', $id)
        ->get();
        $userName = User::findOrFail($id)->name;

        return view('dashboard.layouts.employee_files')
        ->with('departmentStorages', $departmentStorages)
        ->with('userName', $userName);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $storage = DepartmentStorage::findOrfail($id);
        $fileTypes = FileType::all();

        return view('dashboard.layouts.edit-file')
        ->with([
            'storage' => $storage,
            'fileTypes' => $fileTypes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentStorageRequest $request, DepartmentStorage $departmentStorage)
    {
        $validatedData = $request->validated();

        // dd( $validatedData);
        $fileType = FileType::find($validatedData['file_type']);
        $departmentId = auth()->user()->Depatrment_id;
        
        // dd($request->all(), $departmentId,$fileType);
        $departmentStorage = DepartmentStorage::find($request->id);
        $departmentStorage->update([
            'title'=>$request->title,
            'department_id' => $departmentId,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'file_type' => $fileType->id,
        ]);

        flash()->success('file "'.$request->title.'" has been updated');
        return redirect(route('show-file'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Storagetitle = DepartmentStorage::findOrFail($id)->title;
        $Storage = DepartmentStorage::findOrFail($id)->delete();
        flash()->success('file "'.$Storagetitle.'" has been deleted');
        return back();
    }


    // public function getURL(){
    //     return Storage::temporaryUrl('file.png', now()->addSeconds(20));
    // }

    // public function download(){
    //     return Storage::download();
    // }


}
