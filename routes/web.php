<?php

use App\Http\Controllers\DepartmentStorageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CategoryController;

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

    Route::get('/dashboard', function () {
        return view('dashboard.layouts.home');
    });
    
    
    Route::get('/dashboard', function () {
        return view('dashboard.layouts.home');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::get('/table',[TableController::class,'table'])->name('table');

    Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');
});






require __DIR__.'/auth.php';
