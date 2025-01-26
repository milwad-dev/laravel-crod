<?php

namespace Milwad\LaravelCrod\Commands\Modules;

use Binafy\LaravelStub\Facades\LaravelStub;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Milwad\LaravelCrod\Facades\LaravelCrodServiceFacade;
use Milwad\LaravelCrod\Traits\CommonTrait;

class MakeCrudModuleCommand extends Command
{
    use CommonTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:make-module {module_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create crud files for module.';

    /**
     * The module namesapce.
     *
     * @var string
     */
    protected string $module_namespace;

    /**
     * Create a new console command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->module_namespace = config('laravel-crod.modules.module_namespace', 'Modules');
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('module_name');

        $this->alert(sprintf('Publishing crud files for module %s', $this->name));

        $this->makeModel($name);
        $this->makeMigration($name);
        $this->makeController($name);
        $this->makeRequest($name);
        $this->makeView($name);
        $this->makeProvider($name);
        $this->makeRoute($name);

        /*
         * When all files created, after say to user need to make more files like: factory, seeder, etc.
         */
        $this->extraOptionOperation($name);

        $this->info(sprintf('Crud files successfully generated for module %s', $name));
    }

    /**
     * Create model class for module.
     */
    protected function makeModel(string $name): void
    {
        $modelPath = config('laravel-crod.modules.model_path', 'Entities');

        LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/model.stub'))
            ->to($this->getDestPath($name, $modelPath))
            ->name($name)
            ->ext('php')
            ->replaces([
                '$NAMESPACE$'  => $this->getNamespace($name, $modelPath),
                '$CLASS_NAME$' => $name,
            ])
            ->generate();
    }

    /**
     * Create migration class for module.
     */
    protected function makeMigration(string $name): void
    {
        $migrationPath = config('laravel-crod.modules.migration_path', 'Database/Migrations');
        $relativePath = "$this->module_namespace/$name/$migrationPath";
        $fullPath = base_path($relativePath);

        // Ensure the directory exists
        if (!File::isDirectory($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        // Generate the migration name
        $currentNameWithCheckLatestLetter = LaravelCrodServiceFacade::getCurrentNameWithCheckLatestLetter($name);

        // Call the make:migration Artisan command
        $this->call('make:migration', [
            'name'     => 'create_' . $currentNameWithCheckLatestLetter . '_table',
            '--path'   => $relativePath,
            '--create' => true,
        ]);
    }

    /**
     * Create controller class for module.
     */
    protected function makeController(string $name): void
    {
        $controllerPath = config('laravel-crod.modules.controller_path', 'Http\Controllers');

        LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/controller.stub'))
            ->to($this->getDestPath($name, $controllerPath))
            ->name("{$name}Controller")
            ->ext('php')
            ->replaces([
                '$NAMESPACE$'  => $this->getNamespace($name, $controllerPath),
                '$CLASS_NAME$' => "{$name}Controller",
            ])
            ->generate();
    }

    /**
     * Create request class for module.
     */
    protected function makeRequest(string $name)
    {
        $requestPath = config('laravel-crod.modules.request_path', 'Http\Requests');

        // Store
        LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/request.stub'))
            ->to($this->getDestPath($name, $requestPath))
            ->name("{$name}StoreReqeust")
            ->ext('php')
            ->replaces([
                '$NAMESPACE$'  => $this->getNamespace($name, $requestPath),
                '$CLASS_NAME$' => "{$name}StoreReqeust",
            ])
            ->generate();

        // Update
        LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/request.stub'))
            ->to($this->getDestPath($name, $requestPath))
            ->name("{$name}UpdateRequest")
            ->ext('php')
            ->replaces([
                '$NAMESPACE$'  => $this->getNamespace($name, $requestPath),
                '$CLASS_NAME$' => "{$name}UpdateRequest",
            ])
            ->generate();
    }

    /**
     * Create views for module.
     */
    protected function makeView(string $name): void
    {
        $viewPath = config('laravel-crod.modules.view_path', 'Resources\Views');
        $pathSource = $this->getDestPath($name, $viewPath);

        // Index
        LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/blade.stub'))
            ->to($pathSource)
            ->name('index')
            ->ext('blade.php')
            ->generate();

        // Create
        LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/blade.stub'))
            ->to($pathSource)
            ->name('create')
            ->ext('blade.php')
            ->generate();

        // Edit
        LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/blade.stub'))
            ->to($pathSource)
            ->name('edit')
            ->ext('blade.php')
            ->generate();
    }

    /**
     * Create provider class for module.
     */
    protected function makeProvider(string $name): void
    {
        $providerPath = config('laravel-crod.modules.provider_path', 'Providers');

        LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/provider.stub'))
            ->to($this->getDestPath($name, $providerPath))
            ->name("{$name}ServiceProvider")
            ->ext('php')
            ->replaces([
                '$NAMESPACE$'  => $this->getNamespace($name, $providerPath),
                '$CLASS_NAME$' => "{$name}ServiceProvider",
            ])
            ->generate();
    }

    /**
     * Create route for module.
     */
    protected function makeRoute(string $name): void
    {
        $routePath = config('laravel-crod.modules.route_path', 'Routes');
        $routeLatest = config('laravel-crod.route_namespace', '');
        $routeName = config('laravel-crod.route_name', 'web');

        LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/route.stub'))
            ->to($this->getDestPath($name, $routePath))
            ->name($routeName.$routeLatest)
            ->ext('php')
            ->generate();
    }

    /**
     * Create service class for module.
     */
    protected function makeService(string $name): void
    {
        $servicePath = config('laravel-crod.modules.service_path', 'Services');

        LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/service.stub'))
            ->to($this->getDestPath($name, $servicePath))
            ->name("{$name}Service")
            ->ext('php')
            ->replaces([
                '$NAMESPACE$'  => $this->getNamespace($name, $servicePath),
                '$CLASS_NAME$' => "{$name}Service",
            ])
            ->generate();
    }

    /**
     * Create repository class for module.
     */
    protected function makeRepository(string $name): void
    {
        $repositoryPath = config('laravel-crod.modules.repository_path', 'Repositories');
        $latestName = config('laravel-crod.repository_namespace', 'Repository');

        LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/repository.stub'))
            ->to($this->getDestPath($name, $repositoryPath))
            ->name("{$name}{$latestName}")
            ->ext('php')
            ->replaces([
                '$NAMESPACE$'  => $this->getNamespace($name, $repositoryPath),
                '$CLASS_NAME$' => "{$name}{$latestName}",
            ])
            ->generate();
    }

    /**
     * Create feature & unit test.
     */
    protected function makeTest(string $name): void
    {
        $featureTestPath = config('laravel-crod.modules.feature_test_path', 'Tests\Feature');
        $unitTestPath = config('laravel-crod.modules.unit_test_path', 'Tests\Unit');

        if (config('laravel-crod.are_using_pest', false)) {
            LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/pest-test.stub'))
                ->to($this->getDestPath($name, $featureTestPath))
                ->name("{$name}Test")
                ->ext('php')
                ->generate();
        } else {
            // Feature
            LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/feature-test.stub'))
                ->to($this->getDestPath($name, $featureTestPath))
                ->name("{$name}Test")
                ->ext('php')
                ->replaces([
                    '$NAMESPACE$'  => $this->getNamespace($name, $featureTestPath),
                    '$CLASS_NAME$' => "{$name}Test",
                ])
                ->generate();

            LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/unit-test.stub'))
                ->to($this->getDestPath($name, $unitTestPath))
                ->name("{$name}Test")
                ->ext('php')
                ->replaces([
                    '$NAMESPACE$'  => $this->getNamespace($name, $unitTestPath),
                    '$CLASS_NAME$' => "{$name}Test",
                ])
                ->generate();
        }
    }

    /**
     * Create seeder class for module.
     */
    protected function makeSeeder(string $name): void
    {
        $seederPath = config('laravel-crod.modules.seeder_path', 'Database\Seeders');

        LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/seeder.stub'))
            ->to($this->getDestPath($name, $seederPath))
            ->name("{$name}Seeder")
            ->ext('php')
            ->replaces([
                '$NAMESPACE$'  => $this->getNamespace($name, $seederPath),
                '$CLASS_NAME$' => "{$name}Seeder",
            ])
            ->generate();
    }

    /**
     * Create factory class for module.
     */
    protected function makeFactory(string $name): void
    {
        $factoryPath = config('laravel-crod.modules.factory_path', 'Database\Factories');

        LaravelStub::from(realpath(__DIR__.'/../../Stubs/module/factory.stub'))
            ->to($this->getDestPath($name, $factoryPath))
            ->name("{$name}Factory")
            ->ext('php')
            ->replaces([
                '$NAMESPACE$'  => $this->getNamespace($name, $factoryPath),
                '$CLASS_NAME$' => "{$name}Factory",
            ])
            ->generate();
    }

    /**
     * Get correct namespace.
     */
    protected function getNamespace(string $name, string $path): string
    {
        return sprintf("%s\%s\%s", $this->module_namespace, $name, $path);
    }

    /**
     * Get the destination path.
     */
    protected function getDestPath(string $name, string $path): string
    {
        $path = str_replace('\\', '/', $path);
        $to = base_path("$this->module_namespace/$name/$path");
        if (!File::isDirectory($to)) {
            File::makeDirectory($to, 0755, true);
        }

        return $to;
    }
}
