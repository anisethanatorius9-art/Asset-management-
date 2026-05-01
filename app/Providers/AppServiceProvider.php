<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Register custom Flux table component if not auto-registered
        \Illuminate\Support\Facades\Blade::component('vendor.flux.components.table', 'flux::table');
    }
}
