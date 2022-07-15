<?php

namespace Milwad\LaravelCrod\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class MakeCrudCommand extends Command
{
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

        $this->info('Crud successfully generate...');
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
        }

        $this->call('make:migration', ['name' => "create_{$name}ies_table", '--create']);
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
        $this->makeStubFile('App\\Repositories', $name, 'Repo', '/../Stubs/repo.stub');
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

    /**
     * Return the stub file path.
     *
     * @return string
     */
    public function getStubPath($path)
    {
        return __DIR__ . $path;
    }

    /**
     * Map the stub variables present in stub to its value.
     *
     * @return array
     */
    public function getStubVariables($namespace, $name)
    {
        return [
            'NAMESPACE'         => $namespace,
            'CLASS_NAME'        => $this->getSingularClassName($name),
        ];
    }

    /**
     * Get the stub path and the stub variables.
     *
     * @return array|false|string|string[]
     */
    public function getSourceFile($path, $namespace, $name)
    {
        return $this->getStubContents(
            $this->getStubPath($path),
            $this->getStubVariables($namespace, $name)
        );
    }

    /**
     * Replace the stub variables(key) with the desire value.
     *
     * @param $stub
     * @param array $stubVariables
     * @return array|false|string|string[]
     */
    public function getStubContents($stub , $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$'.$search.'$' , $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class.
     *
     * @return string
     */
    public function getSourceFilePath($path, $name, $latest, $singular = true)
    {
        if (!$singular) {
            return base_path($path) .'\\' . $name . "$latest.php";
        }

        return base_path($path) .'\\' .$this->getSingularClassName($name) . "$latest.php";
    }

    /**
     * Return the singular capitalize name.
     *
     * @param $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     * @return string
     */
    public function makeDirectory(string $path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * Build stub & check exists.
     *
     * @param $pathSource
     * @param string $name
     * @param string $latest
     * @param $pathStub
     * @param bool $singular
     * @return void
     */
    private function makeStubFile($pathSource, string $name, string $latest, $pathStub, bool $singular = true): void
    {
        $path = $this->getSourceFilePath($pathSource, $name, $latest, $singular);
        $this->makeDirectory(dirname($path));
        $contents = $this->getSourceFile($pathStub, $pathSource, $name);

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }
}
