<?php

use App\Http\Controllers\DepartmentStorageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\WelcomeController;
use App\Models\DepartmentStorage;


Route::middleware('auth')->group(function () {
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/' , [WelcomeController::class ,'index'])->name('welcome');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

Route::middleware(['auth-check'])->group(function () {

    Route::get('/upload-file' , [DepartmentStorageController::class , 'create'])->name('upload-file');
    Route::post('/upload-file' , [DepartmentStorageController::class , 'store'])->name('upload-file');
    Route::get('/show-file' , [DepartmentStorageController::class , 'showfile'])->name('show-file');
    Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/dashboard' , [DashboardController::class , 'index'])->name('dashboard');

    
    
 
    Route::get('/table',[TableController::class,'table'])->name('table');

    Route::get('category/{id}', [CategoryController::class, 'show'])->name('category.show');
    Route::post('/add-category', [CategoryController::class , 'store'])->name('category.store');
    // Route::get('/search',[SearchController::class , 'index'])->name('search');
    
    Route::get('/all-file', [CategoryController::class, 'showall'])->name('category.show.all');
    Route::get('/administration-files', [AdministrationController::class, 'administrationfiles'])->name('administration.files');


    Route::delete('/file/{id}', [DepartmentStorageController::class, 'destroy'])->name('destroy');
    Route::get('/file/{id}/edit', [DepartmentStorageController::class, 'edit'])->name('edit.file');
    Route::patch('/file/{id}', [DepartmentStorageController::class, 'update'])->name('update.file');

    Route::get('view/{departmentStorage}', function (DepartmentStorage $departmentStorage) {
        $filePath = Storage::disk('local')->path($departmentStorage->file);
        $file = Storage::disk('local')->get($departmentStorage->file);
        return response($file, 200)->header('Content-Type', mime_content_type($filePath));
    })->name('departmentStorage.view');


    
});






require __DIR__.'/auth.php';
