<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Xammp server using mysql 5.0.12-dev so 1071 (Specified key was too long) problem
        // is still there, default str length can fix it
        Schema::defaultStringLength(191);
    }
}
