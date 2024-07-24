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

        

        return view('dashboard.layouts.category', [
            'category' => $category,
            'storageItems' => $storageItems,
        ]);
    }

    public function showall()
    {
    $storageItems = DepartmentStorage::with('user',)->get();
    return view('dashboard.layouts.allcategory')
    ->with('storageItems',$storageItems);
    }

}
