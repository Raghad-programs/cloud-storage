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

}
