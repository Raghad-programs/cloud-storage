<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\DepartmentStorage;
class CategoryController extends Controller
{
    public function show($categoryId)
    {
        $category = Category::findOrFail($categoryId);
       
        $storageItems = DepartmentStorage::where("category_id" , $categoryId)
        ->with('user')        
        ->get();
    
        return view('dashboard.layouts.category', [
            'category' => $category,
            'storageItems' => $storageItems,
        ]);
    }

    public function downloadFile($id)
{
    // 1. Retrieve the file information based on the $id parameter
    $file = DepartmentStorage::findOrFail($id);

    // 2. Check if the file exists
    $filePath = storage_path('app/public/' . $file->file);
    if (!file_exists($filePath)) {
        // If the file doesn't exist, return an error response
        return response()->json(['error' => 'File not found'], 404);
    }

    // 3. Get the file mime type
    $mimeType = Storage::mimeType('app/public/' . $file->file);

    // 4. Return the file as a download
    return response()->download($filePath, $file->title, [
        'Content-Type' => $mimeType,
        'Content-Disposition' => 'attachment; filename="' . $file->title . '"'
    ]);
}

}
