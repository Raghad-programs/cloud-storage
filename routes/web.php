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



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

Route::middleware(['auth-check'])->group(function () {

    Route::get('/upload-file' , [DepartmentStorageController::class , 'create'])->name('upload-file');
    Route::post('/upload-file' , [DepartmentStorageController::class , 'store'])->name('upload-file');
    Route::get('/show-file' , [DepartmentStorageController::class , 'showfile'])->name('show-file');
    Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/dashboard' , [DashboardController::class , 'index'])->name('dashboard');

    
    
 
    Route::get('/table',[TableController::class,'table'])->name('table');

    Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');

    // Route::get('/search',[SearchController::class , 'index'])->name('search');
    
    Route::get('/all-file', [CategoryController::class, 'showall'])->name('category.show.all');
    Route::get('/administration-files', [AdministrationController::class, 'administrationfiles'])->name('administration.files');
    
    // Route::get('/category/{categoryId}', [CategoryController::class, 'search'])->name('your-route-name.index');
    Route::get('/category/{categoryId}/search', [CategoryController::class, 'search'])->name('category.search');
});






require __DIR__.'/auth.php';
