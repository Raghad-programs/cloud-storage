<?php

use App\Http\Controllers\DepartmentStorageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\WelcomeController;
use App\Models\DepartmentStorage;
use App\Http\Controllers\downloadallController;
use App\Http\Controllers\NotificationController;



Route::get('/' , [WelcomeController::class ,'index'])->name('welcome');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);


Route::middleware(['auth-check'])->group(function () {

    Route::get('/dashboard' , [DashboardController::class , 'index'])->name('dashboard');

    //all user profile routes
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');  
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //uploading a file
    Route::get('/upload-file' , [DepartmentStorageController::class , 'create'])->name('upload-file');
    Route::post('/upload-file' , [DepartmentStorageController::class , 'store'])->name('upload-file');
    //update a file
    Route::get('/file/{id}/edit', [DepartmentStorageController::class, 'edit'])->name('edit.file');
    Route::patch('/file/{id}', [DepartmentStorageController::class, 'update'])->name('update.file');
    //download single file
    Route::get('download/{departmentStorage}', [DepartmentStorageController::class, 'downloadFile'])->name('departmentStorage.download'); 
    //download all files
    Route::get('download-all',[downloadallController::class, 'index'])->name('download.all');
    //delete a file
    Route::delete('/file/{id}', [DepartmentStorageController::class, 'destroy'])->name('destroy');
    // display a file
    Route::get('view/{departmentStorage}', function (DepartmentStorage $departmentStorage) {
        $filePath = Storage::disk('local')->path($departmentStorage->file);
        $file = Storage::disk('local')->get($departmentStorage->file);
        return response($file, 200)->header('Content-Type', mime_content_type($filePath));
    })->name('departmentStorage.view');


    //shows user files 
    Route::get('/show-file' , [DepartmentStorageController::class , 'showfile'])->name('show-file');
    //show all files in user department
    Route::get('/all-file', [CategoryController::class, 'showall'])->name('category.show.all');
    //shows files based on category
    Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');

    
    //filetypes
    Route::get('/file-types/show', [AdministrationController::class, 'getFileTypes'])->name('getfile.types');
    Route::get('/file-types/create', [AdministrationController::class, 'create'])->name('file-types.create');
    Route::post('/file-types', [AdministrationController::class, 'store'])->name('file-types.store');
    Route::get('/file-types/{id}/edit', [AdministrationController::class, 'edit'])->name('edit.filetype');
    Route::patch('/file-types/{id}', [AdministrationController::class, 'update'])->name('update.filetype');    
    Route::delete('/file-type/{id}', [AdministrationController::class, 'destroy'])->name('destroy.filetype');

    //notifications
    Route::post('/notifications/markAllAsRead', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

});


Route::middleware(['head-auth'])->group(function () {

    //show files of all departments 
    Route::get('/administration-files', [AdministrationController::class, 'administrationfiles'])
    ->name('administration.files');
    //adds new category
    Route::post('/add-category', [CategoryController::class , 'store'])->name('category.store');
    //all employees table
    Route::get('/employees',[EmployeesController::class,'table'])->name('table');
    //single employee profile
    Route::get('/employee-profile/{id}', [EmployeesController::class, 'profileShow'])->name('employee.profile');
    //show single employee files
    Route::get('/employee/{id}', [EmployeesController::class, 'show_employee'])->name('show-employee');
    //edit storage for employee
    Route::put('/edit-permission/{id}' , [EmployeesController::class , 'editStorageSize'])->name('edit.Storage.Size');
    //change emolyee department
    Route::put('/change-department/{id}' , [EmployeesController::class , 'editUserDepartment'])->name('change.department');
    //delete employee
    Route::delete('/employees/{id}', [EmployeesController::class, 'destroy'])->name('user.destroy');

});











    






require __DIR__.'/auth.php';
