<?php

namespace App\Http\Controllers;
use App\Models\DepartmentStorage;
use Illuminate\Http\Request;

class downloadallController extends Controller
{
    public function index()
{
    try {
        $departmentStorages = DepartmentStorage::where('user_id', auth()->id())->get();
        $zipFile = new \ZipArchive();
        $zipFileName = 'all_files.zip';
        $zipFile->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        foreach ($departmentStorages as $storage) {
            $filePath = storage_path('app/public/department_storage/') . $storage->file;
            $zipFile->addFile($filePath, $storage->title);
        }
        $zipFile->close();
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred during the file download.'], 500);
    }
}
}
