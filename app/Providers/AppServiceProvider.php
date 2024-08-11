<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use View;
use Auth;
use App\Policies\UserPolicy;
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
            'dashboard.admin.*',
            'profile.partials.profile',
            'profile.edit', 
        ], function ($view) {
                $currentUserDepartment = auth()->user()->Depatrment_id;
                $categories = Category::where('department_id', $currentUserDepartment)->get();
                $view->with('categories', $categories);
        });
    }

    protected $policies = [
        User::class => UserPolicy::class,
    ];
}

