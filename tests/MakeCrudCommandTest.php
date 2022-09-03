<?php

namespace Milwad\LaravelCrod\Commands;

class MakeCrudCommandTest extends BaseTest
{
    /**
     * @var string
     */
    private string $name = 'Crod';

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
        $this->artisan("crud:make $this->name");

        $this->checkModelExists();
        $this->checkMigrationExists();
        $this->checkControllerExists();
        $this->checkRequestValidationExists();
        $this->checkViewExists();
    }


    /**
     * Test call command & make crud files with service, repository & tests successfully.
     *
     * @test
     * @return void
     */
    public function make_crud_with_command_with_service_repository_tests()
    {
        $this->artisan("crud:make $this->name --service --repo --test");

        $this->checkModelExists();
        $this->checkMigrationExists();
        $this->checkControllerExists();
        $this->checkRequestValidationExists();
        $this->checkViewExists();
        $this->checkServiceExists();
        $this->checkRepositoryExists();
        $this->checkTestExists();
    }

    /**
     * Check model is exists.
     *
     * @return void
     */
    private function checkModelExists()
    {
        $this->assertEquals(1, file_exists(base_path("App\Models\\$this->name.php")));
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
     * @return void
     */
    private function checkControllerExists()
    {
        $this->assertEquals(
            1,
            file_exists(base_path("App\Http\Controllers\\{$this->name}Controller.php"))
        );
    }

    /**
     * Check request validation file exists.
     *
     * @return void
     */
    private function checkRequestValidationExists()
    {
        $this->assertEquals(
            1,
            file_exists(base_path("App\Http\Requests\\{$this->name}Request.php"))
        );
    }

    /**
     * Check view file exists.
     *
     * @return void
     */
    private function checkViewExists()
    {
        $this->name = strtolower($this->name);
        $this->assertEquals(
            1,
            file_exists(base_path("Resources\Views\\{$this->name}s.blade.php"))
        );
    }

    /**
     * Check service file exists.
     *
     * @return void
     */
    private function checkServiceExists()
    {
        $this->assertEquals(
            1,
            file_exists(base_path("App\Services\\{$this->name}Service.php"))
        );
    }

    /**
     * Check repository file exists.
     *
     * @return void
     */
    private function checkRepositoryExists()
    {
        $this->assertEquals(
            1,
            file_exists(base_path("App\Repositories\\{$this->name}Repo.php"))
        );
    }

    /**
     * Check test file exists.
     *
     * @return void
     */
    private function checkTestExists()
    {
        $this->assertEquals(
            1,
            file_exists(base_path("Tests\Feature\\{$this->name}Test.php"))
        );
        $this->assertEquals(
            1,
            file_exists(base_path("Tests\Unit\\{$this->name}Test.php"))
        );
    }
}
