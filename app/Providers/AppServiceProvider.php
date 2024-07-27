<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use View;
use Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    $this->gateBasedCategories();
}

    protected function gateBasedCategories(): void
    {
   
    View::composer([
        'dashboard.layouts.*', 
    ], function ($view) {
            $currentUserDepartment = auth()->user()->Depatrment_id;
            $categories = Category::where('department_id', $currentUserDepartment)->get();
            $view->with('categories', $categories);
    });
    }
}

