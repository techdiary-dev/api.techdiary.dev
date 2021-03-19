<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
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

//        $this->app->bind(
//            \Backpack\PermissionManager\app\Http\Controllers\UserCrudController::class, //this is package controller
//            \App\Http\Controllers\Admin\UserCrudController::class //this should be your own controller
//        );

        /**
         * Enable Laravel Telescope only for dev environment
         */
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @param UrlGenerator $url
     * @return void
     */
    public function boot(UrlGenerator $url)
    {


        /**
         * Enable https
         */
        if (env('ENABLE_HTTPS', false) || $this->app->environment('production')) {
            $url->forceScheme('https');
        }
    }
}
