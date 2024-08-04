<?php

namespace App\Http\Controllers;
use App\Models\DepartmentStorage;
use Illuminate\Http\Request;
use Log;

class downloadallController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();
    $files = $user->departmentStorages()->get();

    $zipName = 'user_files.zip';
    $zip = new \ZipArchive();
    $zip->open($zipName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

    foreach ($files as $file) {
        $filePath = storage_path('app/' . $file->file);
        $fileExtension = $file->fileType->type;
        $fileName = $file->title;

        switch ($fileExtension) {
            case 'Document':
                $fileName .= '.docx';
                break;
            case 'Powerpoint':
                $fileName .= '.pptx';
                break;
            case 'Image':
                $fileName .= '.jpg'; 
                break;
            case 'Video':
                $fileName .= '.mp4';
                break;
            case 'PDF':
                $fileName .= '.pdf';
                break;
            default:
                $fileName .= '.' . $fileExtension;
                break;
        }

        if (file_exists($filePath)) {
            $zip->addFile($filePath, $fileName);
        } else {
            Log::error("File not found: $filePath");
        }
    }

    $zip->close();

    if ($zip->status !== \ZipArchive::ER_OK) {
        Log::error("Error creating ZIP archive: " . $zip->getStatusString());
        flash()->error('Error creating ZIP archive');
        return response()->json(['error' => 'Error creating ZIP archive'], 500);
    }

    flash()->success('Files have been downloaded successfully');
    return response()->download($zipName)->deleteFileAfterSend(true);
}  
}



