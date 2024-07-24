<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function search(Request $request, $categoryId)
    {
        $search = $request->input('search');
        $category = Category::findOrFail($categoryId);
        $storageItems = DepartmentStorage::where('category_id', $categoryId)
                        ->when($search, function ($query) use ($search) {
                            $query->where('title', 'like', '%'.$search.'%');
                        })
                        ->get();

        return view('dashboard.layouts.category', compact('category', 'storageItems'));
    }
    public function showall()
    {
    $storageItems = DepartmentStorage::with('user',)->get();
    return view('dashboard.layouts.allcategory')
    ->with('storageItems',$storageItems);
    }

}
