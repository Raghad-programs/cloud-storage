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
use App\lang;



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
        $folderName = $this->getFolderName($fileType->type);
        $file = $request->file('file');
        
        // Check file size
        $this->checkFileSize($fileType->type, $file);
        
        // Check total file size
        if ($this->checkTotalFileSize(auth()->id(), auth()->user()->Department_id, $fileType, $file->getSize())) {
            // Store the file temporarily
            $filePath = $file->store('temp', 'local');
            
            // Scan and handle the file
            $result = $this->scanAndHandleFile(storage_path("app/{$filePath}"), $file, $fileType, $folderName, $request);
            
            if ($result['status'] === 'success') {
                flash()->success(__('strings.store_success'));
                return redirect(route('upload-file'));
            } else {
                flash()->error($result['message']);
                return redirect(route('upload-file'));
            }
        } else {
            flash()->error(__('strings.store_fail_limit'));
            return redirect(route('upload-file'));
        }
    }
    
    private function scanAndHandleFile($filePath, $file, $fileType, $folderName, $request)
{
    $virusTotalService = app(VirusTotalService::class);
    $scanResponse = $virusTotalService->scanFile($filePath);

    \Log::info('VirusTotal Scan Response: ', $scanResponse);

    if (isset($scanResponse['response_code']) && $scanResponse['response_code'] == 1) {
        $resource = $scanResponse['resource']; //Get the resource identifier for the file

        // Retry mechanism
        //The retry mechanism gives the VirusTotal scan some time to complete.
        // Instead of trying to get the report immediately after scanning.
        $retries = 5;
        while ($retries > 0) { //will attempt to retrieve the scan report 5 times
            $reportResponse = $virusTotalService->getReport($resource);  // Attempt to get the report

            \Log::info('VirusTotal Report Response: ', $reportResponse);

            if (isset($reportResponse['positives'])) { // If the report is ready
                if ($reportResponse['positives'] == 0) { //  If no threats are detected
                    $finalPath = $file->store("department_storage/{$folderName}", 'local');
                    $this->createDepartmentStorage($request, $fileType, $finalPath, $file->getSize());

                    $user = $request->user();
                    $message = 'A new file has been uploaded by user ' . $user->name;
                    $user->notifyDepartmentAdmins($message);
                    $user->notify(new FileUploaded('Your file has been successfully uploaded.'));

                    return ['status' => 'success'];
                } else {
                    return ['status' => 'error', 'message' => __('strings.fail_flagged')];
                }
            } elseif (isset($reportResponse['response_code']) && $reportResponse['response_code'] == 1) {
                // Report is not ready, retry after a delay
                sleep(10); // wait for 10 seconds before retrying between each retry
                //This gives VirusTotal more time to complete the scan.
                $retries--;
            } else {
                // Handle cases where the report is not available or there's an error
                $errorMessage = isset($reportResponse['verbose_msg']) ? $reportResponse['verbose_msg'] : __('strings.scan_not');
                return ['status' => 'error', 'message' => $errorMessage];
            }
        }

        // After retries, if the report is still not ready
        return ['status' => 'error', 'message' => __('strings.scan_not_time')];
    } else {
         // Handle error cases during file scanning
        $errorMessage = isset($scanResponse['verbose_msg']) ? $scanResponse['verbose_msg'] : __('strings.error_scan');
        return ['status' => 'error', 'message' => $errorMessage];
    }
}



    





    protected function getFolderName($fileType)
    {
        return strtolower($fileType);
    }

    protected function checkFileSize($fileType, $file)
    {
        $maxFileSize = $this->getMaxFileSize($fileType);
        if ($file->getSize() > $maxFileSize * 1024 * 1024) {
            return redirect(route('upload-file'));
        }
    }

    protected function checkTotalFileSize($userId, $departmentId, $fileType, $fileSize)
    {
        $user = User::findOrFail($userId);
        $totalFileSize = $this->getUserTotalFileSize($userId, $departmentId);
    
        if ($totalFileSize + $fileSize > $user->storage_size * 1024 * 1024) { // Convert to bytes
            return false;
        }
    
        return true;
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
        // 'file "'.$request->title.'" has been updated'
        flash()->success(__('strings.file_update', ['attribute' => $request->title]));
      
        return redirect(route('show-file'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $Storagetitle = DepartmentStorage::findOrFail($id)->title;
        $Storage = DepartmentStorage::findOrFail($id)->delete();
        flash()->success(__('strings.file_delete' , ['attribute' => $Storagetitle]));
        $user = $request->user();
        $message = 'A file has been deleted by ' . $user->first_name." ".$user->last_name;
    
        // Notify department admins
        $user->notifyDepartmentAdminsOnDeletion($message);
        // Notify the user
        $user->notify(new FileDeleted('You have successfully deleted a file.'));


        return back();
    }

}
