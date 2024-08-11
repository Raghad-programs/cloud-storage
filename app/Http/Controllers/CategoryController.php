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


    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $filesCount = DepartmentStorage::where('category_id', $category->id)->count();

        if ($filesCount > 0) {
        flash()->error('Cannot delete category as it has associated files.');
        return redirect()->back();
        } else {
        // Delete the category
        $category->delete();
        flash()->success('Category deleted successfully.');
        return redirect()->route('dashboard');
        }
    }

}