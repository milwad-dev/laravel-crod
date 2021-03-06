<?php

namespace Milwad\LaravelCrod;

use Illuminate\Support\ServiceProvider;
use Milwad\LaravelCrod\Commands\{MakeCrudCommand, MakeCrudModuleCommand, MakeQueryCommand, MakeQueryModuleCommand};

class LaravelCrodServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            MakeCrudCommand::class,
            MakeQueryCommand::class,
            MakeCrudModuleCommand::class,
            MakeQueryModuleCommand::class,
        ]);

        $this->publishes(
            [__DIR__ . '/../config/laravel-crod.php' => config_path('laravel-crod.php')], 'config'
        );
    }
}
