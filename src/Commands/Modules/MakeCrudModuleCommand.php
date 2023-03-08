<?php

namespace Milwad\LaravelCrod\Commands\Modules;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Milwad\LaravelCrod\Traits\StubTrait;

class MakeCrudModuleCommand extends Command
{
    use StubTrait;

    protected $signature = 'crud:make-module {module_name} {--service} {--repo} {--test}';

    protected $description = 'Command description';

    private string $module_name_space;
    public Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
        $this->module_name_space = config('laravel-crod.modules.module_namespace', 'Modules');
    }

    public function handle()
    {
        $this->alert('Publishing crud files for module...');

        $name = $this->argument('module_name');

        $this->makeModel($name);
        $this->makeMigration($name);
        $this->makeController($name);
        $this->makeRequest($name);
        $this->makeView($name);

        if ($this->option('service')) {
            $this->makeService($name);
        }
        if ($this->option('repo')) {
            $this->makeRepository($name);
        }
        if ($this->option('test')) {
            $this->makeTest($name);
        }

        $this->info('Crud successfully generate...');
    }

    /**
     *  Build model file with call command for module.
     *
     * @param string $name
     * @return void
     */
    private function makeModel(string $name)
    {
        $model = config('laravel-crod.modules.model_path', 'Entities');

        $this->makeStubFile(
            $this->module_name_space . "\\$name\\$model",
            $name,
            '',
            '/../Stubs/module/model.stub'
        );
    }

    /**
     * Build migration file with call command.
     *
     * @param string $name
     * @return void
     */
    private function makeMigration(string $name)
    {
        $migrationPath = config('laravel-crod.modules.migration_path', 'Database\Migrations');
        $path = "$this->module_name_space\\$name\\$migrationPath";

        $this->call('make:migration', [
            'name' => $this->getRealNameForMigration($name),
            '--path' => $path,
            '--create'
        ]);
    }

    /**
     * Build controller file with call command for module.
     *
     * @param string $name
     * @return void
     */
    private function makeController(string $name)
    {
        $controllerPath = config('laravel-crod.modules.controller_path', 'Http\Controllers');

        $this->makeStubFile(
            $this->module_name_space . "\\$name\\$controllerPath",
            $name,
            'Controller',
            '/../Stubs/module/controller.stub'
        );
    }

    /**
     * Build request file with call command for module.
     *
     * @param string $name
     * @return void
     */
    private function makeRequest(string $name)
    {
        $requestPath = config('laravel-crod.modules.request_path', 'Http\Requests');

        $this->makeStubFile(
            $this->module_name_space . "\\$name\\$requestPath",
            $name,
            'Request',
            '/../Stubs/module/request.stub'
        );
    }


    /**
     * Build view file with call command for module.
     *
     * @param string $name
     * @return void
     */
    private function makeView(string $name)
    {
        $viewPath = config('laravel-crod.modules.view_path', 'Resources/Views');

        $this->makeStubFile(
            $this->module_name_space . "\\$name\\$viewPath",
            strtolower($name) . 's',
            '.blade',
            '/../Stubs/module/blade.stub',
            false,
        );
    }

    /**
     * Build service file with call command for module.
     *
     * @param string $name
     * @return void
     */
    private function makeService(string $name)
    {
        $servicePath = config('laravel-crod.modules.service_path', 'Services');

        $this->makeStubFile(
            $this->module_name_space . "\\$name\\$servicePath",
            $name,
            'Service',
            '/../Stubs/module/service.stub'
        );
    }

    /**
     * Build repository file with call command for module.
     *
     * @param string $name
     * @return void
     */
    private function makeRepository(string $name)
    {
        $repositoryPath = config('laravel-crod.modules.repository_path', 'Repositories');

        $this->makeStubFile(
            $this->module_name_space . "\\$name\\$repositoryPath",
            $name,
            config('laravel-crod.modules.repository_namespace', 'Repo'),
            '/../Stubs/module/repo.stub'
        );
    }

    /**
     * Build feature & unit test.
     *
     * @param string $name
     * @return void
     */
    private function makeTest(string $name)
    {
        $featureTestPath = config('laravel-crod.modules.feature_test_path', 'Tests\Feature');
        $unitTestPath = config('laravel-crod.modules.unit_test_path', 'Tests\Unit');

        $this->makeStubFile(
            $this->module_name_space . "\\$name\\$featureTestPath",
            $name,
            'Test',
            '/../Stubs/module/feature-test.stub'
        );
        $this->makeStubFile(
            $this->module_name_space . "\\$name\\$unitTestPath",
            $name,
            'Test',
            '/../Stubs/module/unit-test.stub'
        );
    }

    /**
     * Get real name of migration.
     *
     * @param string $name
     * @return string
     */
    private function getRealNameForMigration(string $name): string
    {
        if (\str_ends_with($name, 'y')) {
            $name = substr_replace($name, "", -1);
            return "create{$name}ies_table";
        }

        return "create{$name}s_table";
    }
}
