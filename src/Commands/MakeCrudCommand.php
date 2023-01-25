<?php

namespace Milwad\LaravelCrod\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
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

        $this->info('Crud successfully generates...');
    }

    /**
     * Build model file with call command.
     *
     * @param string $name
     * @return void
     */
    private function makeModel(string $name)
    {
        $this->call('make:model', ['name' => $name]);
    }

    /**
     * Build migration file with call command.
     *
     * @param string $name
     * @return void
     */
    private function makeMigration(string $name)
    {
        if (!str_ends_with($name, 'y')) {
            $this->call('make:migration', ['name' => "create_{$name}s_table", '--create']);
        } else {
            $name = substr_replace($name ,"", -1);
            $this->call('make:migration', ['name' => "create_{$name}ies_table", '--create']);
        }
    }

    /**
     * Build controller file with call command.
     *
     * @param string $name
     * @return void
     */
    private function makeController(string $name)
    {
        $this->call('make:controller', ['name' => "{$name}Controller"]);
    }

    /**
     * Build request file with call command.
     *
     * @param string $name
     * @return void
     */
    private function makeRequest(string $name)
    {
        $this->call('make:request', ['name' => "{$name}Request"]);
    }

    /**
     * Build view file with call command.
     *
     * @param string $name
     * @return void
     */
    private function makeView(string $name)
    {
        $name = strtolower($name);

        if (!str_ends_with($name, 'y')) {
            $name .= "s";
        } else {
            $name .= "ies";
        }

        $this->makeStubFile(
            'Resources\\Views',
            strtolower($name) . 's',
            '.blade',
            '/../Stubs/blade.stub',
            false,
        );
    }

    /**
     * Build service file with call command.
     *
     * @param string $name
     * @return void
     */
    private function makeService(string $name)
    {
        $this->makeStubFile('App\\Services', $name, 'Service', '/../Stubs/service.stub');
    }

    /**
     * Build repository file with call command.
     *
     * @param string $name
     * @return void
     */
    private function makeRepository(string $name)
    {
        $this->makeStubFile(
            'App\\Repositories',
            $name,
            config('laravel-crod.modules.repository_namespace'),
            '/../Stubs/repo.stub'
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
        $this->makeStubFile('Tests\\Feature', $name, 'Test', '/../Stubs/feature-test.stub');
        $this->makeStubFile('Tests\\Unit', $name, 'Test', '/../Stubs/unit-test.stub');
    }
}
