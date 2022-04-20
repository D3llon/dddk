<?php

namespace App\Providers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Backpack\PermissionManager\app\Http\Controllers\UserCrudController;
use Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest;
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            UserCrudController::class,
            \App\Http\Controllers\Admin\UserCrudController::class
        );

        $this->app->bind(
            UserStoreCrudRequest::class,
            UserStoreRequest::class
        );

        $this->app->bind(
            UserUpdateCrudRequest::class,
            UserUpdateRequest::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        Paginator::useBootstrapFive();
        Paginator::defaultSimpleView('my-simple-paginator');
        Paginator::defaultView('my-paginator');
    }
}
