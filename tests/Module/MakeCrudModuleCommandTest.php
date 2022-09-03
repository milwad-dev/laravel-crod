<?php

namespace Milwad\LaravelCrod\Commands;

class MakeCrudModuleCommandTest extends BaseTest
{
    /**
     * @var string
     */
    private string $name = 'Crod';

    /**
     * Get make module command;
     *
     * @var string
     */
    private string $command = 'crud:make-module';

    /**
     * Set up.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutMockingConsoleOutput();
    }

    /**
     * Test call command & make crud files successfully.
     *
     * @test
     * @return void
     */
    public function make_crud_with_command()
    {
        $module_namespace = $this->getModuleNamespace();

        $this->artisan("$this->command $this->name");
        $this->checkModelExists($module_namespace);
        $this->checkMigrationExists();
        $this->checkControllerExists($module_namespace);
        $this->checkRequestValidationExists($module_namespace);
        $this->checkViewExists($module_namespace);
    }


    /**
     * Test call command & make crud files with service, repository & tests successfully.
     *
     * @test
     * @return void
     */
    public function make_crud_with_command_with_service_repository_tests()
    {
        $module_namespace = $this->getModuleNamespace();

        $this->artisan("$this->command $this->name --service --repo --test");

        $this->checkModelExists($module_namespace);
        $this->checkMigrationExists();
        $this->checkControllerExists($module_namespace);
        $this->checkRequestValidationExists($module_namespace);
        $this->checkViewExists($module_namespace);
        $this->checkServiceExists($module_namespace);
        $this->checkRepositoryExists($module_namespace);
        $this->checkTestExists($module_namespace);
    }

    /**
     * Check model is exists.
     *
     * @param  string $module_namespace
     * @return void
     */
    private function checkModelExists(string $module_namespace)
    {
        $this->assertEquals(
            1,
            file_exists(base_path("$module_namespace\\$this->name\Entities\\$this->name.php"))
        );
    }

    /**
     * Check migration is exists.
     *
     * @return void
     */
    private function checkMigrationExists()
    {
        $this->name = strtolower($this->name);

        if (!str_ends_with($this->name, 'y')) {
            $file = $this->migrationExists("create_{$this->name}s_table");
        } else {
            $file = $this->migrationExists("create_{$this->name}ies_table");
        }

        $this->assertEquals(1, $file);
    }

    /**
     * Check migration file is exists.
     *
     * @param  string $mgr
     * @return bool
     */
    private function migrationExists(string $mgr)
    {
        $path = database_path('migrations/');
        $files = scandir($path);

        foreach ($files as &$value) {
            $pos = strpos($value, $mgr);
            if ($pos !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check controller exists.
     *
     * @param  string $module_namespace
     * @return void
     */
    private function checkControllerExists(string $module_namespace)
    {
        $this->assertEquals(
            1,
            file_exists(base_path("$module_namespace\\$this->name\Http\Controllers\\{$this->name}Controller.php"))
        );
    }

    /**
     * Check request validation file exists.
     *
     * @param  string $module_namespace
     * @return void
     */
    private function checkRequestValidationExists(string $module_namespace)
    {
        $this->assertEquals(
            1,
            file_exists(base_path("$module_namespace\\$this->name\Http\Requests\\{$this->name}Request.php"))
        );
    }

    /**
     * Check view file exists.
     *
     * @param  string $module_namespace
     * @return void
     */
    private function checkViewExists(string $module_namespace)
    {
        $this->name = strtolower($this->name);
        $this->assertEquals(
            1,
            file_exists(base_path("$module_namespace\\$this->name\Resources\Views\\{$this->name}s.blade.php"))
        );
    }

    /**
     * Check service file exists.
     *
     * @param  string $module_namespace
     * @return void
     */
    private function checkServiceExists(string $module_namespace)
    {
        $this->assertEquals(
            1,
            file_exists(base_path("$module_namespace\\$this->name\Services\\{$this->name}Service.php"))
        );
    }

    /**
     * Check repository file exists.
     *
     * @param  string $module_namespace
     * @return void
     */
    private function checkRepositoryExists(string $module_namespace)
    {
        $this->assertEquals(
            1,
            file_exists(base_path("$module_namespace\\$this->name\Repositories\\{$this->name}Repo.php"))
        );
    }

    /**
     * Check test file exists.
     *
     * @param  string $module_namespace
     * @return void
     */
    private function checkTestExists(string $module_namespace)
    {
        $this->assertEquals(
            1,
            file_exists(base_path("$module_namespace\\$this->name\Tests\Feature\\{$this->name}Test.php"))
        );
        $this->assertEquals(
            1,
            file_exists(base_path("$module_namespace\\$this->name\Tests\Unit\\{$this->name}Test.php"))
        );
    }

    /**
     * Get module namespace from config file.
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|string
     */
    private function getModuleNamespace()
    {
        if (!file_exists(config_path('laravel-crod.php'))) {
            return 'Modules';
        }

        return config('laravel-crod.module_namespace');
    }
}
