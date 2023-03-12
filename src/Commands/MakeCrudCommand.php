<?php

namespace Milwad\LaravelCrod\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Milwad\LaravelCrod\Datas\OptionData;
use Milwad\LaravelCrod\Facades\LaravelCrodServiceFacade;
use Milwad\LaravelCrod\Traits\StubTrait;

class MakeCrudCommand extends Command
{
    use StubTrait;

    protected $signature = 'crud:make {name} {--service} {--repo} {--test}';

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
        $name_lower = strtolower($name);

        $this->makeModel($name_uc);
        $this->makeMigration($name_lower);
        $this->makeController($name_uc);
        $this->makeRequest($name_uc);
        $this->makeView($name_uc);

        if ($this->option('service')) {
            $this->makeService($name_uc);
        }
        if ($this->option('repo')) {
            $this->makeRepository($name_uc);
        }
        if ($this->option('test')) {
            $this->makeTest($name_uc);
        }

        $selectOption = $this->choice('You want something extra?', OptionData::$options, 0);
        match ($selectOption) {
            OptionData::SEEDER_OPTION => $this->makeSeeder(),
            OptionData::FACTORY_OPTION => $this->makeFactory(),
        };

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

        $this->makeStubFile(
            'Resources\\Views',
            $name,
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
     *
     * @return void
     */
    private function makeTest(string $name)
    {
        $this->makeStubFile('Tests\\Feature', $name, 'Test', '/../Stubs/feature-test.stub');
        $this->makeStubFile('Tests\\Unit', $name, 'Test', '/../Stubs/unit-test.stub');
    }
}
