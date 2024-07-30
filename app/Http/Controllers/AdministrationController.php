<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartmentStorage;
use App\Models\Category;


class AdministrationController extends Controller
{
    public function administrationfiles()
{
    $storageItems = DepartmentStorage::with(['department', 'categorys', 'user'])->get();

    $Category=Category::with('departmentStorages');

    return view('dashboard.layouts.administrationfiles', [
        'storageItems' => $storageItems,
        'category'=>$category,
    ]);
    

}

}
