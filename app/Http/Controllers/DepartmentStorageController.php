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
        $filePath = $request->file('file')->store("public/department_storage/{$folderName}");
        $departmentId = auth()->user()->Depatrment_id;
        
        // dd($request->all(), $departmentId,$fileType);
      
        $departmentStorage = DepartmentStorage::create([
            'title'=>$request->title,
            'department_id' => $departmentId,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'file_type' => $fileType->id,
            'file' => $filePath,
        ]);

    

    flash()->success('The file is saved successfully!!');

    if (auth()->user()->role_id == 1) {
        return redirect(route('upload-file'))->with('success', 'Department storage created successfully.');
    } else {
        return redirect(route('upload-file'))->with('success', 'Department storage created successfully.');
    }

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
        $folderName = strtolower($fileType->type);
        $filePath = $request->file('file')->store("public/department_storage/{$folderName}");
        $departmentId = auth()->user()->Depatrment_id;
        
        // dd($request->all(), $departmentId,$fileType);
        $departmentStorage = DepartmentStorage::find($request->id);
        $departmentStorage->update([
            'title'=>$request->title,
            'department_id' => $departmentId,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'file_type' => $fileType->id,
            'file' => $filePath,
        ]);

        flash()->success('file has been updated');
        return redirect(route('show-file'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Storage = DepartmentStorage::findOrFail($id)->delete();
        flash()->success('file has been deleted');
        return redirect(route('show-file'));
    }

}
