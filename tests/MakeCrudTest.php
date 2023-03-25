<?php

namespace Milwad\LaravelCrod\Tests;

class MakeCrudTest extends BaseTest
{
    private string $name = 'Product';

    /**
     * Test check all files create when user run command 'crud:make'.
     *
     * @test
     *
     * @return void
     */
    public function check_to_create_files_with_command_crud_make()
    {
        $this->artisan('crud:make', [
            'name' => $this->name,
        ]);

        $this->checkAllToModelIsCreatedWithOriginalName();
        $this->checkAllToMigrationIsCreatedWithOriginalName();
        $this->checkAllToControllerIsCreatedWithOriginalName();
        $this->checkAllToRequestIsCreatedWithOriginalName();
        $this->checkAllToViewIsCreatedWithOriginalName();
    }

    /**
     * Test check all files create when user run command 'crud:make' with options.
     *
     * @test
     *
     * @return void
     */
    public function check_to_create_files_with_command_crud_make_with_options()
    {
        $this->withoutExceptionHandling();
        $this->artisan('crud:make', [
            'name'      => $this->name,
            '--service' => true,
            '--test'    => true,
            '--repo'    => true,
        ]);

        $this->checkAllToModelIsCreatedWithOriginalName();
        $this->checkAllToMigrationIsCreatedWithOriginalName();
        $this->checkAllToControllerIsCreatedWithOriginalName();
        $this->checkAllToRequestIsCreatedWithOriginalName();
        $this->checkAllToViewIsCreatedWithOriginalName();
        $this->checkAllToServiceIsCreatedWithOriginalName();
        $this->checkAllToRepositoryIsCreatedWithOriginalName();
        $this->checkAllToTestsIsCreatedWithOriginalName();
    }

    /**
     * Test check all files create when user run command 'crud:make' with ies name.
     *
     * @test
     *
     * @return void
     */
    public function check_to_create_files_with_command_crud_make_with_ies_name()
    {
        $this->artisan('crud:make', [
            'name' => 'Category',
        ]);

        $this->checkAllToModelIsCreatedWithOriginalName();
        $this->checkAllToMigrationIsCreatedWithOriginalName();
        $this->checkAllToControllerIsCreatedWithOriginalName();
        $this->checkAllToRequestIsCreatedWithOriginalName();
        $this->checkAllToViewIsCreatedWithOriginalName();
    }

    private function checkAllToModelIsCreatedWithOriginalName(): void
    {
        $filename = app_path("Models\\$this->name.php");

        $this->assertEquals(1, file_exists($filename));
        $this->assertEquals($this->name, basename($filename, '.php'));
    }

    private function checkAllToMigrationIsCreatedWithOriginalName(): void
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
     *
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

    private function checkAllToControllerIsCreatedWithOriginalName(): void
    {
        $controller = $this->name.'Controller';
        $filename = app_path("Http\\Controllers\\$controller.php");

        $this->assertEquals(1, file_exists($filename));
        $this->assertEquals($controller, basename($filename, '.php'));
    }

    private function checkAllToRequestIsCreatedWithOriginalName(): void
    {
        $request = $this->name.'Request';
        $filename = app_path("Http\\Requests\\$request.php");

        $this->assertEquals(1, file_exists($filename));
        $this->assertEquals($request, basename($filename, '.php'));
    }

    private function checkAllToViewIsCreatedWithOriginalName(): void
    {
        $lowerName = strtolower($this->name);
        $latest = str_ends_with($lowerName, 'y') ? 'ies' : 's';
        $view = $lowerName.$latest.'.blade';
        $filename = resource_path("views\\$view.php");

        $this->assertEquals(1, file_exists($filename));
        $this->assertEquals($view, basename($filename, '.php'));
    }

    private function checkAllToServiceIsCreatedWithOriginalName(): void
    {
        $service = ucfirst($this->name).'Service';
        $filename = app_path("Services\\$service.php");

        $this->assertEquals(1, file_exists($filename));
        $this->assertEquals($service, basename($filename, '.php'));
    }

    private function checkAllToRepositoryIsCreatedWithOriginalName(): void
    {
        $latest = config('laravel-crod.repository_namespace', 'Repo');
        $repo = ucfirst($this->name).$latest;
        $filename = app_path("Repositories\\$repo.php");

        $this->assertEquals(1, file_exists($filename));
        $this->assertEquals($repo, basename($filename, '.php'));
    }

    private function checkAllToTestsIsCreatedWithOriginalName(): void
    {
        // Feature test
        $test = ucfirst($this->name).'Test';
        $filename = base_path("Tests\\Feature\\$test.php");

        $this->assertEquals(1, file_exists($filename));
        $this->assertEquals($test, basename($filename, '.php'));

        // Unit test
        $test = ucfirst($this->name).'Test';
        $filename = base_path("Tests\\Unit\\$test.php");

        $this->assertEquals(1, file_exists($filename));
        $this->assertEquals($test, basename($filename, '.php'));
    }
}
