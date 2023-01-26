<?php

namespace Milwad\LaravelCrod\Tests;

class MakeCrudTest extends BaseTest
{
    /**
     * @var string
     */
    private string $name = 'Product';

    /**
     * Test check all files create when user run command 'crud:make'.
     *
     * @test
     * @return void
     */
    public function check_to_create_files_with_command_crud_make()
    {
        $this->artisan("crud:make Product");

        $this->checkAllToModelIsCreatedWithOriginalName();
        $this->checkAllToMigrationIsCreatedWithOriginalName();
        $this->checkAllToControllerIsCreatedWithOriginalName();
        $this->checkAllToRequestIsCreatedWithOriginalName();
    }

    /**
     * @return void
     */
    private function checkAllToModelIsCreatedWithOriginalName(): void
    {
        $filename = app_path("Models\\$this->name.php");

        $this->assertEquals(1, file_exists($filename));
        $this->assertEquals($this->name, basename($filename, '.php'));
    }

    /**
     * @return void
     */
    private function checkAllToMigrationIsCreatedWithOriginalName(): void
    {
        $this->name = strtolower($this->name);

        if (! str_ends_with($this->name, 'y')) {
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
     * @return void
     */
    private function checkAllToControllerIsCreatedWithOriginalName(): void
    {
        $controller = $this->name . 'Controller';
        $filename = app_path("Http\\Controllers\\$controller.php");

        $this->assertEquals(1, file_exists($filename));
        $this->assertEquals($controller, basename($filename, '.php'));
    }

    /**
     * @return void
     */
    private function checkAllToRequestIsCreatedWithOriginalName(): void
    {
        $request = $this->name . 'Request';
        $filename = app_path("Http\\Requests\\$request.php");

        $this->assertEquals(1, file_exists($filename));
        $this->assertEquals($request, basename($filename, '.php'));
    }
}