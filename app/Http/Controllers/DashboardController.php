<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartmentStorage;
use App\Models\FileType;
use App\Models\Department;
use App\Models\User;
use DB;

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

    $recentUpload = DepartmentStorage::where('user_id', auth()->id())
                        ->with('fileType')
                        ->latest()
                        ->first();
                        
    // $totalUserStorage = 2 * 1024 * 1024 * 1024; // 2GB in bytes
    // $userUsedStorage = $this->getUserTotalFileSize(auth()->id(), auth()->user()->Depatrment_id);
    // $userUsedStoragePercentage = round(($userUsedStorage / $totalUserStorage) * 100, 2);

    $totalFileSize = DepartmentStorage::where('user_id', auth()->user()->id)
    ->orWhereNull('id')
    ->sum('file_size');
    
    $employeeStorageLimitInMB = $this->getEmployeeStorage(auth()->user()->id); // Get the storage limit for the employee in MB
    $userUsedStoragePercentage = ($totalFileSize / ($employeeStorageLimitInMB * 1024 * 1024)) * 100;
    $userUsedStoragePercentage = round($userUsedStoragePercentage ,2);


    $totalStorageUsed = $this->getTotalStorageUsed();
    $formattedTotalStorageUsed = $this->formatBytes($totalStorageUsed);




    return view('dashboard.layouts.home', compact(
        'totalDocuments', 'monthlyUploads','documentsPerDepartment',
        'fileTypeDistribution', 'recentUploads', 'topDepartments','DocumentsForUser'
        ,'recentUpload','userUsedStoragePercentage','formattedTotalStorageUsed'
    ));
}

public function getEmployeeStorage($employeeID){
    $employee=User::findOrFail($employeeID);
    $size = $employee->storage_size;
    return $size;
}
    private function getUserTotalFileSize($userId, $departmentId)
    {
    return DepartmentStorage::where('user_id', $userId)
        ->where('department_id', $departmentId)
        ->sum('file_size');
    }

    private function getTotalStorageUsed()
    {
        return DB::table('department_storages')
            ->sum('file_size');
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }


}

