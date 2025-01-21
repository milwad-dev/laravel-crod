<?php

namespace Milwad\LaravelCrod\Commands;

use Binafy\LaravelStub\Facades\LaravelStub;
use Illuminate\Console\Command;
use Milwad\LaravelCrod\Facades\LaravelCrodServiceFacade;
use Milwad\LaravelCrod\Traits\CommonTrait;
use Milwad\LaravelCrod\Traits\StubTrait;

class MakeCrudCommand extends Command
{
    use StubTrait;
    use CommonTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:make {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate CRUD files (model, migration, controller, request, views) and guide additional file creation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->alert('Publishing crud files...');

        $name = $this->argument('name');
        $name_uc = ucfirst($name);

        $this->makeModel($name_uc);
        $this->makeMigration(strtolower($name));
        $this->makeController($name_uc);
        $this->makeRequest($name_uc);
        $this->makeView($name_uc);

        /*
         * When all files created, after say to user need to make more files like: factory, seeder, etc.
         */
        $this->extraOptionOperation($name_uc);

        $this->info('Crud files successfully generated...');
    }

    /**
     * Create model class.
     */
    private function makeModel(string $name): void
    {
        LaravelStub::from(__DIR__ . '/../Stubs/model.stub')
            ->to(app_path('Models')) // TODO: Check models folder exists or not
            ->name($name)
            ->ext('php')
            ->replaces([
                '$NAMESPACE$' => 'App\Models',
                '$CLASS_NAME$' => $name
            ])
            ->generate();
    }

    /**
     * Create migration with call command.
     */
    private function makeMigration(string $name): void
    {
        $name = LaravelCrodServiceFacade::getCurrentNameWithCheckLatestLetter($name);

        $this->call('make:migration', ['name' => "create_{$name}_table", '--create']);
    }

    /**
     * Create controller class.
     */
    private function makeController(string $name): void
    {
        $currentController = config('laravel-crod.main_controller', 'App\Http\Controllers\Controller');

        LaravelStub::from(__DIR__ . '/../Stubs/controller.stub')
            ->to(app_path('Http\Controllers'))
            ->name($name)
            ->ext('php')
            ->replaces([
                '$NAMESPACE$' => 'App\Http\Controllers',
                '$CLASS_NAME$' => "{$name}Controller",
                '$EXTEND_CONTROLLER$' => $currentController
            ])
            ->generate();
    }

    /**
     * Create request classes for store and update operation.
     */
    private function makeRequest(string $name)
    {
        LaravelStub::from(__DIR__ . '/../Stubs/form-request.stub')
            ->to(app_path('Http\Requests'))
            ->name($name)
            ->ext('php')
            ->replaces([
                '$NAMESPACE$' => 'App\Http\Requests',
                '$CLASS_NAME$' => "{$name}StoreRequest",
            ])
            ->generate();

        LaravelStub::from(__DIR__ . '/../Stubs/form-request.stub')
            ->to(app_path('Http\Requests'))
            ->name($name)
            ->ext('php')
            ->replaces([
                '$NAMESPACE$' => 'App\Http\Requests',
                '$CLASS_NAME$' => "{$name}UpdateRequest",
            ])
            ->generate();
    }

    /**
     * Create views (index, create, edit).
     */
    private function makeView(string $name)
    {
        $name = LaravelCrodServiceFacade::getCurrentNameWithCheckLatestLetter($name);
        $to = resource_path('views/'.$name);

        // Index
        LaravelStub::from(__DIR__ . '/../Stubs/blade.stub')
            ->to($to)
            ->name('index')
            ->ext('blade.php')
            ->generate();

        // Create
        LaravelStub::from(__DIR__ . '/../Stubs/blade.stub')
            ->to($to)
            ->name('create')
            ->ext('blade.php')
            ->generate();

        // Edit
        LaravelStub::from(__DIR__ . '/../Stubs/blade.stub')
            ->to($to)
            ->name('edit')
            ->ext('blade.php')
            ->generate();
    }

    /**
     * Create service class.
     */
    private function makeService(string $name): void
    {
        LaravelStub::from(__DIR__ . '/../Stubs/service.stub')
            ->to(app_path('Services/'.$name))
            ->name("{$name}Service")
            ->ext('php')
            ->replaces([
                '$NAMESPACE$' => 'App\Services',
                '$CLASS_NAME$' => "{$name}Service",
            ])
            ->generate();
    }

    /**
     * Create repository class.
     */
    private function makeRepository(string $name): void
    {
        $latest = config('laravel-crod.repository_namespace', 'Repository');

        LaravelStub::from(__DIR__ . '/../Stubs/repository.stub')
            ->to(app_path('Repositories/'.$name))
            ->name("{$name}$latest")
            ->ext('php')
            ->replaces([
                '$NAMESPACE$' => 'App\Repositories',
                '$CLASS_NAME$' => "{$name}$latest",
            ])
            ->generate();
    }

    /**
     * Create feature & unit test.
     */
    private function makeTest(string $name): void
    {
        if (config('laravel-crod.are_using_pest', false)) {
            LaravelStub::from(__DIR__ . '/../Stubs/pest.stub')
                ->to(base_path('tests/Feature'))
                ->name("{$name}Test")
                ->ext('php')
                ->generate();
        } else {
            // Feature
            LaravelStub::from(__DIR__ . '/../Stubs/feature-test.stub')
                ->to(base_path('tests/Feature'))
                ->name("{$name}Test")
                ->ext('php')
                ->replaces([
                    '$NAMESPACE$' => 'Tests\Feature',
                    '$CLASS_NAME$' => "{$name}Test",
                ])
                ->generate();

            // Unit
            LaravelStub::from(__DIR__ . '/../Stubs/unit-test.stub')
                ->to(base_path('tests/Unit'))
                ->name("{$name}Test")
                ->ext('php')
                ->replaces([
                    '$NAMESPACE$' => 'Tests\Unit',
                    '$CLASS_NAME$' => "{$name}Test",
                ])
                ->generate();
        }
    }

    /**
     * Create seeder class.
     */
    private function makeSeeder(string $name)
    {
        LaravelStub::from(__DIR__ . '/../Stubs/seeder.stub')
            ->to(database_path('seeders'))
            ->name("{$name}Seeder")
            ->ext('php')
            ->replaces([
                '$NAMESPACE$' => 'Database\Seeders',
                '$CLASS_NAME$' => "{$name}Seeder",
            ])
            ->generate();
    }

    /**
     * Create factory class.
     */
    private function makeFactory(string $name)
    {
        LaravelStub::from(__DIR__ . '/../Stubs/factory.stub')
            ->to(database_path('factories'))
            ->name("{$name}Factory")
            ->ext('php')
            ->replaces([
                '$NAMESPACE$' => 'Database\Factories',
                '$CLASS_NAME$' => "{$name}Factory",
            ])
            ->generate();
    }
}
