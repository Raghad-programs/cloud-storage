<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\DepartmentStorage;
use App\Models\FileType;


class CategoryController extends Controller
{
    public function show($categoryId , Request $request)
    {
        $category = Category::findOrFail($categoryId);
        $fileTypes = FileType::all();

        $query = DepartmentStorage::where('category_id', $categoryId);

        if ($request->has('file_type') && $request->file_type !== 'all') {
            $query->where('file_type', $request->file_type);
        }

         $storageItems = DepartmentStorage::where("category_id" , $categoryId)
        ->with('user')        
        ->get();
        
    
        $search =request()->search;

        $storageItems = DepartmentStorage::where(function ($query) use ($search, $categoryId) {
            $sq = $search;
            if (isset($sq) && $sq != null) {
                $query->where("category_id", $categoryId)
                    ->where(function ($q) use ($sq) {
                        $q->where('title', 'like', '%'.$sq.'%');
                    });
            }
        })
        ->with('user')
        ->get();

        $storageItems = $query->with('user')->get();


        return view('dashboard.layouts.category', [
            'category' => $category,
            'storageItems' => $storageItems,
            'fileTypes' => $fileTypes
        ]);
    


    }
    public function showall()
    {
    $storageItems = DepartmentStorage::with('user',)->get();
    return view('dashboard.layouts.allcategory')
    ->with('storageItems',$storageItems);
    }

}
