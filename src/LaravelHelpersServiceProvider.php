<?php

namespace Livewirez\LaravelHelpers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Livewirez\LaravelHelpers\Composer\Composer;

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

            $this->setAutoloadFile();
        }
    }

    public function register()
    {

    }

    protected function setAutoloadFile()
    {
        $disk = Storage::build(['driver' => 'local', 'root' => app()->basePath()]);
        
        $composer_file_string = $disk->get('composer.json');

        $composer = new Composer(json_decode($composer_file_string));

        if ($composer->composer_has_files()) {
            $composer->autoload->files[] = "app/Helpers/Helpers.php";
        } else {
            $composer->autoload->files = ["app/Helpers/Helpers.php"]; 
        }

        $disk->put('composer.json', $composer);
    }
}
