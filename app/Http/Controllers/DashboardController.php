<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartmentStorage;
use App\Models\FileType;
use App\Models\Department;

class DashboardController extends Controller
{
    public function index()
{
    $totalDocuments = DepartmentStorage::count();

    $DocumentsForUser = DepartmentStorage::where('user_id', auth()->id())->count();


    $documentsPerDepartment = Department::withCount('departmentStorages')->count();

    
    $monthlyUploads = DepartmentStorage::selectRaw('DATE_FORMAT(created_at, "%b") as month, COUNT(*) as count')
                        ->groupBy('month')
                        ->orderBy('created_at')
                        ->get();
    
    $fileTypeDistribution = FileType::withCount('departmentStorages')
                        ->get()
                        ->pluck('department_storages_count', 'type');
    
    $recentUploads = DepartmentStorage::with('user', 'department')
                        ->latest()
                        ->take(5)
                        ->get();
    
    $topDepartments = Department::withCount('departmentStorages')
                        ->orderByDesc('department_storages_count')
                        ->take(5)
                        ->get();

    return view('dashboard.layouts.home', compact(
        'totalDocuments', 'monthlyUploads','documentsPerDepartment',
        'fileTypeDistribution', 'recentUploads', 'topDepartments','DocumentsForUser'
    ));
}
}
