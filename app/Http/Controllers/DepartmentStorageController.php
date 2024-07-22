<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentStorageRequest;
use App\Http\Requests\UpdateDepartmentStorageRequest;
use App\Models\DepartmentStorage;
use App\Models\FileType;
use App\Models\Category;
use App\Http\Controllers\Request;
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
        
        $currentUserDepartment = auth()->user()->department;
        $categories = Category::where('department_id', $currentUserDepartment->id)->get();
        $departmentStorages = DepartmentStorage::where('department_id', $currentUserDepartment->id)->get();
        
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
    $filePath = $request->file('file')->store("department_storage/{$folderName}");
    $departmentStorage = DepartmentStorage::create([
        'title' => $request->title,
        'department_id' => auth()->user()->department_id,
        'user_id' => auth()->id(),
        'category_id' => $request->category_id,
        'file_type' => $validatedData['file_type'],
        'file' => $filePath,
    ]);

    flash()->success('The file is saved successfully!!');
    return redirect(route('upload-file'))->with('success', 'Department storage created successfully.');

    }
    public function showfile()
    {
        $currentUserDepartment = auth()->user()->department;
        $departmentStorages = DepartmentStorage::where('department_id', $currentUserDepartment->id)
                            ->where('user_id', auth()->id())
                            ->get();
                            $userName = auth()->user()->name;

        return view('dashboard.layouts.showfile')
        ->with('departmentStorages', $departmentStorages)
        ->with('userName', $userName);
    }
    


    /**
     * Display the specified resource.
     */
    public function show(DepartmentStorage $departmentStorage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepartmentStorage $departmentStorage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentStorageRequest $request, DepartmentStorage $departmentStorage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentStorage $departmentStorage)
    {
        //
    }
}
