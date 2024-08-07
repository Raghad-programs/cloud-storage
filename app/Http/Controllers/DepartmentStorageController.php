<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests\StoreDepartmentStorageRequest;
use App\Http\Requests\UpdateDepartmentStorageRequest;
use App\Models\DepartmentStorage;
use App\Models\FileType;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Services\VirusTotalService;
use App\Notifications\FileUploaded;
use App\Notifications\FileDeleted;




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


    public function store(StoreDepartmentStorageRequest $request,VirusTotalService $virusTotalService)
    {
        $validatedData = $request->validated();
        $fileType = FileType::find($validatedData['file_type']);
        $folderName = $this->getFolderName($fileType->type);
        $file = $request->file('file');


        // Scan the file using VirusTotal
        $scanResult = $virusTotalService->scanFile($file->getPathname());

        // Handle VirusTotal scan result
        if ($scanResult && isset($scanResult['response_code']) && $scanResult['response_code'] === 1 && isset($scanResult['positives']) && $scanResult['positives'] > 0) {
            // Virus found
            flash()->error('Virus detected in the file. File not saved.');
            return redirect(route('upload-file'));
        }
        // Check file size
        $this->checkFileSize($fileType->type, $file);

        // Check total file size
        $this->checkTotalFileSize(auth()->id(), auth()->user()->Depatrment_id, $fileType, $file->getSize());

        // Store the file
        $filePath = $file->store("department_storage/{$folderName}", 'local');
        $this->createDepartmentStorage($request, $fileType, $filePath, $file->getSize());

    //confirmation
    $user = $request->user();
    $message = 'A new file has been uploaded by user ' . $user->name;
    // Notify department admins
    $user->notifyDepartmentAdmins($message);
    // Notify the user
    $user->notify(new FileUploaded('Your file has been successfully uploaded.'));



        flash()->success('The file is saved successfully!!');
        return redirect(route('upload-file'));
    }
    protected function scanFileWithVirusTotal($file, VirusTotalService $virusTotalService)
    {
        // Scan the file using VirusTotal service
        return $virusTotalService->scanFile($file->getPathname());
    }

    protected function getFolderName($fileType)
    {
        return strtolower($fileType);
    }

    protected function checkFileSize($fileType, $file)
    {
        $maxFileSize = $this->getMaxFileSize($fileType);
        if ($file->getSize() > $maxFileSize * 1024 * 1024) {
            flash()->error("The maximum file size for {$fileType} files is {$maxFileSize}MB.");
            return redirect(route('upload-file'));
        }
    }

    protected function checkTotalFileSize($userId, $departmentId, $fileType, $fileSize)
    {
        $user = User::findOrFail($userId);
        $totalFileSize = $this->getUserTotalFileSize($userId, $departmentId);
        if ($totalFileSize + $fileSize > $user->storage_size * 1024 * 1024) { // Convert to bytes
            flash()->error("You have reached the maximum file storage limit of {$user->storage_size}MB for your department.");
            return redirect(route('upload-file'));
        }
    }

    protected function createDepartmentStorage($request, $fileType, $filePath, $fileSize)
    {
        $user = User::findOrFail(auth()->id());
        DepartmentStorage::create([
            'title' => $request->title,
            'department_id' => auth()->user()->Depatrment_id,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'file_type' => $fileType->id,
            'file' => $filePath,
            'file_size' => $fileSize,
            'description' => $request->description,
            'storage_size' => $user->storage_size,
        ]);
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
            'description'=> $request->description,
        ]);

        flash()->success('file "'.$request->title.'" has been updated');
        return redirect(route('show-file'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $Storagetitle = DepartmentStorage::findOrFail($id)->title;
        $Storage = DepartmentStorage::findOrFail($id)->delete();
        flash()->success('file "'.$Storagetitle.'" has been deleted');
        $user = $request->user();
        $message = 'A file has been deleted by user ' . $user->name;
    
        // Notify department admins
        $user->notifyDepartmentAdminsOnDeletion($message);
        // Notify the user
        $user->notify(new FileDeleted('You have successfully deleted a file.'));


        return back();
    }

}
