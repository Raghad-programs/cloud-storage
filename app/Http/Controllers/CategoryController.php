<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\DepartmentStorage;
use App\Models\FileType;

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

        $storageItems = $query->with('user')->get();

        return view('dashboard.layouts.category', [
            'category' => $category,
            'storageItems' => $storageItems,
            'fileTypes' => $fileTypes
        ]);
    }





    public function search(Request $request, $categoryId)
    {
        $search = $request->input('search');
        $category = Category::findOrFail($categoryId);
        $fileTypes = FileType::all(); 
        
        $storageItems = DepartmentStorage::where('category_id', $categoryId)
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->get();

        return view('dashboard.layouts.category', compact('category', 'storageItems', 'fileTypes'));
    }


}
