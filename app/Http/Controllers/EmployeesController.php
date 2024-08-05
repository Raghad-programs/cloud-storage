<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\DepartmentStorage;
use App\Models\Category;

class EmployeesController extends Controller
{
    public function table()
    {
        $search = request()->search;
    
        $users = User::where('Depatrment_id', auth()->user()->Depatrment_id);
    
        if (isset($search) && $search !== null) {
            $users->where('name', 'LIKE', '%' . $search . '%');
        }
    
        $users = $users->get();
    
        return view('dashboard.admin.employees')->with('users', $users);
    }

    
    public function destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        // Redirect back with a success message
        return redirect()->route('table')->with('success', 'User deleted successfully');
    }

    public function show_employee($id)
    {
        $departmentStorages = DepartmentStorage::where('department_id', auth()->user()->Depatrment_id)
        ->where('user_id', $id)
        ->get();
        $userName = User::findOrFail($id)->name;

        return view('dashboard.admin.employee_files')
        ->with('departmentStorages', $departmentStorages)
        ->with('userName', $userName);
    }


    public function profileShow($id){
        $employee = User::findOrFail($id);
        //how many files the employee upload
        $filesNumber = DepartmentStorage::where('department_id', $employee->Depatrment_id)
                                       ->where('user_id', $id)
                                       ->count();
    
        $participationPercentages = $this->calculateParticipationPercentages($employee);
        $employeeStorageLimit = $this->getEmployeeStorage(); // Get the storage limit for the employee
        $currentUserDepartment = $employee->Depatrment_id; //user department
        $categories = Category::where('department_id', $currentUserDepartment)->get(); //user department categories
    
        $fileSizes = [];
        $totalFileSize = 0;
        foreach ($categories as $category) {
            $categoryFileSize = DepartmentStorage::where('department_id', $currentUserDepartment)
                                                ->where('category_id', $category->id)
                                                ->where('user_id', $id)
                                                ->sum('file_size');
            $fileSizes[$category->name] = round($categoryFileSize / 1024 / 1024, 2); // Convert bytes to MB and round to 2 decimal places
            $totalFileSize += $categoryFileSize;
        }
    
        $totalFileSizeInGB = round($totalFileSize / 1024 / 1024 / 1024, 2); // Convert bytes to GB and round to 2 decimal places
        $usagePercentage = ($totalFileSize / $employeeStorageLimit) * 100; // Calculate usage percentage based on 2 GB limit
    
        return view('dashboard.admin.employee_profile')
            ->with([
                'employee' => $employee,
                'filesNumber' => $filesNumber,
                'participationPercentages' => $participationPercentages,
                'categories' => $categories,
                'fileSizes' => $fileSizes,
                'totalFileSizeInGB' => $totalFileSizeInGB,
                'usagePercentage' => $usagePercentage,
                'employeeStorageLimit' => $employeeStorageLimit,
            ]);
    }

    private function calculateParticipationPercentages($employee)
    {
        $totalFiles = DepartmentStorage::where('department_id', $employee->Depatrment_id)
            ->where('user_id', $employee->id)
            ->count();

        $participationPercentages = [];

        $currentUserDepartment = $employee->Depatrment_id;
        $categories = Category::where('department_id', $currentUserDepartment)->get();

        foreach ($categories as $category) {
            $fileCount = $category->departmentStorages()
                ->where('department_id', auth()->user()->Depatrment_id)
                ->where('user_id', $employee->id)
                ->count();
            if ($totalFiles > 0) {
            $percentage = ($fileCount / $totalFiles) * 100;
            $participationPercentages[$category->name] = round($percentage, 2);
            }else{
                $participationPercentages[$category->name] = 0;
            }
         
        }

        return $participationPercentages;
    }

    public function getEmployeeStorage(){
        return (2 * 1024 * 1024 * 1024);
    }

}
