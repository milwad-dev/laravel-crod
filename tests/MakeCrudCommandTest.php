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
     * @param  $mgr
     * @return bool
     */
    private function migrationExists($mgr)
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
}
