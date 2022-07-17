<?php

namespace Milwad\LaravelCrod\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class MakeCrudModuleCommand extends Command
{
    protected $signature = 'crud:make-module {module_name} {--service} {--repo} {--test}';

    protected $description = 'Command description';

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

    public string $module_name_space;
    public Filesystem $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
        $this->module_name_space = config('laravel-crod.module_namespace') ?? 'Modules';
    }

    /**
     *  Build model file with call command for module.
     *
     * @param string $name
     * @return void
     */
    private function makeModel(string $name)
    {
        $this->makeStubFile(
            $this->module_name_space . "\\$name\\Entities",
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
        if (!str_ends_with($name, 'y')) {
            $this->call('make:migration', [
                'name' => "create_{$name}s_table",
                '--create',
                "--path=/$this->module_name_space/$name/Database/Migrations"
            ]);
        } else {
            $name = substr_replace($name ,"", -1);
            $this->call('make:migration', [
                'name' => "create_{$name}ies_table",
                '--create',
                "--path=/$this->module_name_space/$name/Database/Migrations"
            ]);
        }
    }

    /**
     * Build controller file with call command for module.
     *
     * @param string $name
     * @return void
     */
    private function makeController(string $name)
    {
        $this->makeStubFile(
            $this->module_name_space . "\\$name\\Http\\Controllers",
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
        $this->makeStubFile(
            $this->module_name_space . "\\$name\\Http\\Requests",
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
        $this->makeStubFile(
            $this->module_name_space . "\\$name\\Resources\\views",
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
        $this->makeStubFile(
            $this->module_name_space . "\\$name\\Services",
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
        $this->makeStubFile(
            $this->module_name_space . "\\$name\\Repositories",
            $name,
            'Repo',
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
        $this->makeStubFile(
            $this->module_name_space . "\\$name\\Tests\\Feature",
            $name,
            'Test',
            '/../Stubs/module/feature-test.stub'
        );
        $this->makeStubFile(
            $this->module_name_space . "\\$name\\Tests\\Unit",
            $name,
            'Test',
            '/../Stubs/module/unit-test.stub'
        );
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
