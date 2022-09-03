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

        $this->checkModelExitst();
    }

    /**
     * Check model is exists.
     *
     * @return void
     */
    private function checkModelExitst()
    {
        $this->assertEquals(1, file_exists(base_path("App\Models\\$this->name.php")));
    }
}
