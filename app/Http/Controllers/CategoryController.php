<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\DepartmentStorage;
use App\Models\FileType;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    public function show($categoryId, Request $request)
{
    $category = Category::findOrFail($categoryId);
    $fileTypes = FileType::all();

    $query = DepartmentStorage::where('category_id', $categoryId);

    if ($request->has('file_type') && $request->file_type !== 'all') {
        $query->where('file_type', $request->file_type);
    }

    if ($request->has('search') && $request->search !== null) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%');
        });
    }

    $storageItems = $query->with('user')->get();

    return view('dashboard.layouts.category', [
        'category' => $category,
        'storageItems' => $storageItems,
        'fileTypes' => $fileTypes,
    ]);
}


    public function showall()
    {
        $search =request()->search;

        $storageItems = DepartmentStorage::where(function ($query) use ($search) {
            $sq = $search;
            if (isset($sq) && $sq != null) {
                $query->where(function ($q) use ($sq) {
                        $q->where('title', 'like', '%'.$sq.'%');
                    });
            }
        })->get();

        // $storageItems = DepartmentStorage::with('user',)->get();

        return view('dashboard.layouts.allcategory')
        ->with('storageItems',$storageItems);
    }


    public function store(Request $request)
    {
    
    $category = Category::create([
        'name' => $request->input('name'),
        'department_id' => auth()->user()->Depatrment_id,
    ]);

    flash()->success('Category created successfully');
    return redirect('dashboard');
    }

    public function downloadFile($id)
    {
        $item = DepartmentStorage::findOrFail($id);

    if ($item->file_path) {
        $filePath = Storage::disk('public')->path($item->file_path);
        if (file_exists($filePath)) {
            return response()->download($filePath, $item->file_name);
        } else {
            // Handle the case where the file does not exist
            return redirect()->back()->with('error', 'The requested file does not exist.');
        }
    } else {
        // Handle the case where the file path is null
        return redirect()->back()->with('error', 'The file is not available for download.');
    }
    }


}