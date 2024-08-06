<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartmentStorage;
use App\Models\Category;
use App\Models\FileType;



class AdministrationController extends Controller
{
    public function administrationfiles()
    {
    $storageItems = DepartmentStorage::with(['department', 'category', 'user'])->get();

    $Category=Category::with('departmentStorages');

    return view('dashboard.admin.administrationfiles', [
        'storageItems' => $storageItems,
        'category'=>$Category,
    ]);

    }

    public function create()
    {
        return view('dashboard.admin.file_types');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'extensions' => 'required|array',
            'extensions.*' => 'string|max:255',
        ]);
    
        // Convert the array of extensions into a comma-separated string
        $extensions = implode(', ', $request->input('extensions'));
    
        $fileType = FileType::create([
            'type' => $request->input('type'),
            'extensions' => $extensions, // Store as a comma-separated string
        ]);
    
        return redirect()
            ->route('file-types.create')
            ->with('success', 'File type created successfully.');
    }
    

}
