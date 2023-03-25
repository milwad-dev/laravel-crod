<?php

namespace Milwad\LaravelCrod\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Milwad\LaravelCrod\Facades\LaravelCrodServiceFacade;
use Milwad\LaravelCrod\Traits\CommonTrait;
use Milwad\LaravelCrod\Traits\StubTrait;

class MakeCrudCommand extends Command
{
    use StubTrait;
    use CommonTrait;

    protected $signature = 'crud:make {name}';

    protected $description = 'Make crud fast';

    public Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

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
     * Build model file with call command.
     *
     *
     * @return void
     */
    private function makeModel(string $name)
    {
        $this->call('make:model', ['name' => $name]);
    }

    /**
     * Build migration file with call command.
     *
     *
     * @return void
     */
    private function makeMigration(string $name)
    {
        $name = LaravelCrodServiceFacade::getCurrentNameWithCheckLatestLetter($name);

        $this->call('make:migration', ['name' => "create_{$name}_table", '--create']);
    }

    /**
     * Build controller file with call command.
     *
     *
     * @return void
     */
    private function makeController(string $name)
    {
        $this->call('make:controller', ['name' => "{$name}Controller"]);
    }

    /**
     * Build request file with call command.
     *
     *
     * @return void
     */
    private function makeRequest(string $name)
    {
        $this->call('make:request', ['name' => "{$name}StoreRequest"]);
        $this->call('make:request', ['name' => "{$name}UpdateRequest"]);
    }

    /**
     * Build view file with call command.
     *
     *
     * @return void
     */
    private function makeView(string $name)
    {
        $name = LaravelCrodServiceFacade::getCurrentNameWithCheckLatestLetter($name);

        $pathSource = 'Resources\\Views\\'.$name;
        $this->makeStubFile(
            $pathSource,
            'index',
            '.blade',
            '/../Stubs/blade.stub',
            false,
        );
        $this->makeStubFile(
            $pathSource,
            'create',
            '.blade',
            '/../Stubs/blade.stub',
            false,
        );
        $this->makeStubFile(
            $pathSource,
            'edit',
            '.blade',
            '/../Stubs/blade.stub',
            false,
        );
    }

    /**
     * Build service file with call command.
     *
     *
     * @return void
     */
    private function makeService(string $name)
    {
        $this->makeStubFile('App\\Services', $name, 'Service', '/../Stubs/service.stub');
    }

    /**
     * Build repository file with call command.
     *
     *
     * @return void
     */
    private function makeRepository(string $name)
    {
        $this->makeStubFile(
            'App\\Repositories',
            $name,
            config('laravel-crod.repository_namespace', 'Repo'),
            '/../Stubs/repo.stub'
        );
    }

    /**
     * Build feature & unit test.
     *
     * @param string $name
     *
     * @return void
     */
    private function makeTest(string $name)
    {
        if (config('laravel-crod.are_using_pest', false)) {
            $this->call('make:test', ['--pest' => true]);
        } else {
            $this->makeStubFile('Tests\\Feature', $name, 'Test', '/../Stubs/feature-test.stub');
            $this->makeStubFile('Tests\\Unit', $name, 'Test', '/../Stubs/unit-test.stub');
        }
    }

    /**
     * Build seeder file with call command.
     *
     * @param string $name
     *
     * @return void
     */
    private function makeSeeder(string $name)
    {
        $this->call('make:seeder', [
            'name' => $name.'Seeder',
        ]);
    }

    /**
     * Build factory file with call command.
     *
     * @param string $name
     *
     * @return void
     */
    private function makeFactory(string $name)
    {
        $this->call('make:factory', [
            'name' => $name.'Factory',
        ]);
    }
}
