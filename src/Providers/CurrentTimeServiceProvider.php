<?php

namespace Thtg88\MmCms\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CurrentTimeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $now = app('now')->copy();

        if($this->app->runningInConsole() === false)
        {
            View::share('now', $now);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register current time singleton
        $this->app->singleton('now', function($app) {
            return Carbon::now();
        });
    }
}
