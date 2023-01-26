<?php

namespace Milwad\LaravelCrod;

use Illuminate\Support\ServiceProvider;
use Milwad\LaravelCrod\Commands\{MakeCrudCommand,
    MakeQueryCommand,
    Modules\MakeCrudModuleCommand,
    Modules\MakeQueryModuleCommand};

class LaravelCrodServiceProvider extends ServiceProvider
{
    /**
     * Register files.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            MakeCrudCommand::class,
            MakeQueryCommand::class,
            MakeCrudModuleCommand::class,
            MakeQueryModuleCommand::class,
        ]);

        $this->publishes([
            __DIR__ . '/../config/laravel-crod.php' => config_path('laravel-crod.php')
        ], 'config');
    }
}
