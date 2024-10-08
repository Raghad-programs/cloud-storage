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


    public function showall(Request $request)
    {
        $fileTypes = FileType::all();
        $user = auth()->user(); // Get the authenticated user

        // Start the query
        // $query = DepartmentStorage::query();
        // Filter by user's department
        
        $query=DepartmentStorage::where('department_id', $user->Depatrment_id);

        if ($request->has('file_type') && $request->file_type !== 'all') {
            $query->where('file_type', $request->file_type);
        }
    
        if ($request->has('search') && $request->search !== null) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            });
        }

        $storageItems = $query->with('user')->get();

         return view('dashboard.layouts.allcategory', [
            'storageItems' => $storageItems,
            'fileTypes' => $fileTypes,
        ]);
    }


    public function store(Request $request)
    {
    
        $category = Category::create([
            'name' => $request->input('name'),
            'name_ar' => $request->input('name_ar'),
            'department_id' => auth()->user()->Depatrment_id,
        ]);

        flash()->success(__('strings.category_create'));
        return redirect('dashboard');
    }


    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $filesCount = DepartmentStorage::where('category_id', $category->id)->count();

        if ($filesCount > 0) {
        flash()->error(__('strings.cate_not_delete'));
        return redirect()->back();
        } else {
        // Delete the category
        $category->delete();
        flash()->success(__('strings.category_delete'));
        return redirect()->route('dashboard');
        }
    }

}