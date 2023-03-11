<?php

namespace Milwad\LaravelCrod;

use Illuminate\Support\ServiceProvider;
use Milwad\LaravelCrod\Commands\MakeCrudCommand;
use Milwad\LaravelCrod\Commands\MakeQueryCommand;
use Milwad\LaravelCrod\Commands\Modules\MakeCrudModuleCommand;
use Milwad\LaravelCrod\Commands\Modules\MakeQueryModuleCommand;
use Milwad\LaravelCrod\Services\LaravelCrodService;

class LaravelCrodServiceProvider extends ServiceProvider
{
    /**
     * Register files.
     *
     * @return void
     */
    public function register()
    {
        $this->loadCommands();
        $this->publishFiles();
        $this->bindFacades();
    }

    /**
     * @return void
     */
    public function loadCommands(): void
    {
        $this->commands([
            MakeCrudCommand::class,
            MakeQueryCommand::class,
            MakeCrudModuleCommand::class,
            MakeQueryModuleCommand::class,
        ]);
    }

    /**
     * Publish files.
     *
     * @return void
     */
    public function publishFiles(): void
    {
        $this->publishes([
            __DIR__.'/../config/laravel-crod.php' => config_path('laravel-crod.php'),
        ], 'laravel-crod-config');
    }

    /**
     * Bind facades.
     *
     * @return void
     */
    public function bindFacades(): void
    {
        $this->app->bind('laravel-crod-service', function () {
            return new LaravelCrodService();
        });
    }
}
