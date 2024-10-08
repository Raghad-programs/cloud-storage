<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartmentStorage;
use App\Models\Category;
use App\Models\FileType;



class AdministrationController extends Controller
{
    public function administrationfiles(Request $request)
    {
    // $storageItems = DepartmentStorage::with(['department', 'category', 'user'])->get();
    $Category=Category::with('departmentStorages');
    $fileTypes = FileType::all();
    $query = DepartmentStorage::query();

    if ($request->has('file_type') && $request->file_type !== 'all') {
        $query->where('file_type', $request->file_type);
    }

    if ($request->has('search') && $request->search !== null) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%');
        });
    }

    $storageItems = $query->with(['department', 'category', 'user'])->get();

    return view('dashboard.admin.administrationfiles', [
        'storageItems' => $storageItems,
        'category'=>$Category,
        'fileTypes' => $fileTypes
    ]);

    }

    public function create()
    {
        $fileTypes = FileType::all();
    return view('dashboard.admin.file_types', compact('fileTypes'));
    }

    public function store(Request $request)
    {
        // Validate the input fields
        $validated = $request->validate([
            'type' => 'required|string|max:255|regex:/^[a-zA-Z]+$/',
            'extensions' => 'required|array',
            'extensions.*' => 'string|max:255|regex:/^[a-zA-Z]+$/'
        ], [
            'type.regex' => __('showfileandtypes.x1'),
            'extensions.*.regex' => __('showfileandtypes.x2')
        ]);
    
        // If validation passes, process the data
        $extensions = implode(',', $request->input('extensions')); // Convert the array to a comma-separated string
    
        // Create the new file type
        FileType::create([
            'type' => $request->input('type'),
            'extensions' => $extensions, // Store the comma-separated string
        ]);
    
        // Flash success message
        flash()->success(__('showfileandtypes.Flash_File_Type_creation'));
    
        // Redirect to the file types list
        return redirect(route('getfile.types'));
    }
    


public function update(Request $request, $id)
{
    $fileType = FileType::findOrFail($id);

    $validatedData = $request->validate([
        'type' => 'required|string',
        'extensions' => 'nullable|array', // Allow extensions to be nullable
        'extensions.*' => 'nullable|string|max:255', // Allow individual extensions to be nullable
    ]);

    $fileType->type = $validatedData['type'];

    // Check if extensions were provided in the request
    if (isset($validatedData['extensions'])) {
        $fileType->extensions = implode(', ', $validatedData['extensions']);
    }

    $fileType->save();
    flash()->success(__('showfileandtypes.Flash_File_Type_update'));
    return redirect()->route('getfile.types');
}



    public function getFileTypes()
    {   
        $fileTypes = FileType::all();
        return view('dashboard.admin.file_types', compact('fileTypes'));
    }

   
    public function edit(Request $request, $id)
{
    $fileType = FileType::findOrFail($id);
    $extensions = explode(',', $fileType->extensions);
    return view('dashboard.admin.edit_file_type', compact('fileType', 'extensions'));
}
    
public function destroy($id)
{
    $fileType = FileType::findOrFail($id);
    $fileType->delete();
    flash()->success(__('showfileandtypes.Flash_File_Type_deletion'));
    return back();
} 
    

}

