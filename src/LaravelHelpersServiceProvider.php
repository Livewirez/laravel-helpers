<?php

namespace Livewirez\LaravelHelpers;

use Illuminate\Support\ServiceProvider;

class LaravelHelpersServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (app()->runningInConsole()) {

            $helper_file = app_path().'/Helpers/Helpers.php';

            if (! file_exists($helper_file)) {
                $this->publishes([
                    __DIR__.'/Helpers/Helpers.php' => app_path('Helpers/Helpers.php'),
                ], 'laravel-helpers');
            }
        }
    }

    public function register()
    {

    }
}
